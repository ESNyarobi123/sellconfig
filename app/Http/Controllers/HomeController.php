<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Order;
use App\Models\Setting;
use App\Services\HarakaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show home/landing page with plans
     */
    public function index()
    {
        $plans = Plan::where('is_active', true)
            ->withCount([
                'configs as available_count' => function ($query) {
                    $query->where('status', 'available');
                }
            ])
            ->orderBy('price')
            ->get();

        return view('home', compact('plans'));
    }

    /**
     * Show plan details
     */
    public function showPlan(Plan $plan)
    {
        if (!$plan->is_active) {
            abort(404);
        }

        $plan->loadCount([
            'configs as available_count' => function ($query) {
                $query->where('status', 'available');
            }
        ]);

        return view('plan.show', compact('plan'));
    }

    /**
     * Show checkout page where user can enter payment phone
     */
    public function showCheckout(Plan $plan)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Unahitaji kuingia kwanza.');
        }

        if (!$plan->is_active) {
            abort(404);
        }

        if (!$plan->hasStock()) {
            return back()->with('error', 'Samahani, hakuna config zilizobaki kwa plan hii.');
        }

        return view('order.checkout', compact('plan'));
    }

    /**
     * Initiate purchase
     */
    public function initiatePurchase(Request $request, Plan $plan)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Unahitaji kuingia kwanza.');
        }

        // Validate payment phone
        $validated = $request->validate([
            'payment_phone' => 'required|regex:/^0[0-9]{9}$/',
        ], [
            'payment_phone.required' => 'Namba ya malipo inahitajika.',
            'payment_phone.regex' => 'Namba ya simu lazima iwe na tarakimu 10 (mfano: 0712345678)',
        ]);

        if (!$plan->hasStock()) {
            return back()->with('error', 'Samahani, hakuna config zilizobaki kwa plan hii.');
        }

        $user = Auth::user();
        $paymentPhone = $validated['payment_phone'];
        $harakaPay = new HarakaPayService();

        // Check if payment is enabled
        if (!$harakaPay->isEnabled()) {
            // Test mode - create order and deliver directly
            $order = Order::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'payment_phone' => $paymentPhone,
                'payment_status' => 'completed',
                'order_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Deliver config
            if ($order->deliverConfig()) {
                return redirect()->route('order.success', $order)
                    ->with('success', 'Umefanikiwa kupata config! (Test Mode)');
            } else {
                $order->update(['order_status' => 'cancelled']);
                return back()->with('error', 'Samahani, hakuna config zilizobaki.');
            }
        }

        // Create pending order
        $order = Order::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'payment_phone' => $paymentPhone,
            'payment_status' => 'pending',
        ]);

        // Initiate payment with the provided payment phone
        $description = "Kununua {$plan->name}";
        $result = $harakaPay->collectPayment($paymentPhone, $plan->price, $description);

        if (!$result['success']) {
            $order->update(['payment_status' => 'failed', 'order_status' => 'cancelled']);
            return back()->with('error', $result['error'] ?? 'Imeshindikana kutuma ombi la malipo.');
        }

        // Update order with payment info
        $order->update([
            'payment_order_id' => $result['order_id'],
            'net_amount' => $result['net_amount'] ?? null,
            'fee_amount' => $result['fee'] ?? null,
            'payment_status' => 'processing',
        ]);

        return redirect()->route('order.waiting', $order);
    }

    /**
     * Show payment waiting page (polling)
     */
    public function waitingPayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->order_status === 'delivered') {
            return redirect()->route('order.success', $order);
        }

        return view('order.waiting', compact('order'));
    }

    /**
     * Check payment status (for AJAX polling)
     */
    public function checkPaymentStatus(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // If already delivered
        if ($order->order_status === 'delivered') {
            return response()->json([
                'status' => 'completed',
                'order_status' => 'delivered',
                'redirect' => route('order.success', $order),
            ]);
        }

        // If already failed
        if ($order->payment_status === 'failed') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Malipo yameshindikana.',
            ]);
        }

        // Check with HarakaPay
        $harakaPay = new HarakaPayService();
        $result = $harakaPay->checkStatus($order->payment_order_id);

        if (!$result['success']) {
            return response()->json([
                'status' => 'checking',
                'message' => 'Inaendelea kusubiri malipo...',
            ]);
        }

        $paymentStatus = $result['payment']['status'] ?? 'pending';

        if ($paymentStatus === 'completed') {
            // Payment completed - deliver config
            $order->update([
                'payment_status' => 'completed',
                'order_status' => 'paid',
                'paid_at' => now(),
            ]);

            if ($order->deliverConfig()) {
                return response()->json([
                    'status' => 'completed',
                    'order_status' => 'delivered',
                    'redirect' => route('order.success', $order),
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Samahani, hakuna config zilizobaki. Pesa yako itarudishwa.',
                ]);
            }
        }

        if ($paymentStatus === 'failed') {
            $order->update([
                'payment_status' => 'failed',
                'order_status' => 'cancelled',
            ]);

            return response()->json([
                'status' => 'failed',
                'message' => 'Malipo yameshindikana.',
            ]);
        }

        return response()->json([
            'status' => 'pending',
            'message' => 'Inasubiri uthibitisho wa malipo...',
        ]);
    }

    /**
     * Show order success page
     */
    public function orderSuccess(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['plan', 'config']);

        return view('order.success', compact('order'));
    }

    /**
     * Show user's purchase history
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['plan', 'config'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('history', compact('orders'));
    }

    /**
     * Show single order detail
     */
    public function showOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['plan', 'config']);

        return view('order.show', compact('order'));
    }
}
