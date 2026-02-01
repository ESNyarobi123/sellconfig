<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\User;
use App\Services\HarakaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_sales' => Order::where('payment_status', 'completed')->sum('amount'),
            'total_orders' => Order::where('payment_status', 'completed')->count(),
            'total_configs' => Config::count(),
            'available_configs' => Config::where('status', 'available')->count(),
            'sold_configs' => Config::where('status', 'sold')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_plans' => Plan::count(),
        ];

        // Recent orders
        $recentOrders = Order::with(['user', 'plan'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Get HarakaPay balance
        $harakaPay = new HarakaPayService();
        $balance = $harakaPay->getBalance();

        // Top selling plans
        $topPlans = Plan::withCount([
            'orders' => function ($query) {
                $query->where('payment_status', 'completed');
            }
        ])->orderByDesc('orders_count')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'balance', 'topPlans'));
    }

    /**
     * Show settings page
     */
    /**
     * Show settings page
     */
    public function settings()
    {
        $settings = [
            'harakapay_api_key' => Setting::get('harakapay_api_key', ''),
            'payment_enabled' => Setting::get('payment_enabled', true),
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'whatsapp_link' => Setting::get('whatsapp_link', 'https://wa.me/260966122504'),
            'youtube_link' => Setting::get('youtube_link', 'https://www.youtube.com/@CyberHunter-b6n3t'),
            'app_halotel_link' => Setting::get('app_halotel_link', 'https://uploadapk.store/view-app.php?id=226'),
            'app_airtel_link' => Setting::get('app_airtel_link', '#'),
            'site_name' => Setting::get('site_name', 'SellConfig'),
            'support_message' => Setting::get('support_message', ''),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'harakapay_api_key' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'whatsapp_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'app_halotel_link' => 'nullable|url',
            'app_airtel_link' => 'nullable|url',
            'site_name' => 'nullable|string|max:255',
            'support_message' => 'nullable|string',
        ]);

        Setting::set('harakapay_api_key', $request->harakapay_api_key);
        Setting::set('payment_enabled', $request->boolean('payment_enabled'), 'boolean');
        Setting::set('whatsapp_number', $request->whatsapp_number);
        Setting::set('whatsapp_link', $request->whatsapp_link);
        Setting::set('youtube_link', $request->youtube_link);
        Setting::set('app_halotel_link', $request->app_halotel_link);
        Setting::set('app_airtel_link', $request->app_airtel_link);
        Setting::set('site_name', $request->site_name);
        Setting::set('support_message', $request->support_message);

        return back()->with('success', 'Mipangilio imehifadhiwa!');
    }

    /**
     * Show all users
     */
    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount([
                'orders' => function ($query) {
                    $query->where('payment_status', 'completed');
                }
            ])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Toggle user active status
     */
    public function toggleUser(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'Hali ya mtumiaji imebadilishwa.');
    }

    /**
     * Show sales history
     */
    public function sales(Request $request)
    {
        $query = Order::with(['user', 'plan', 'config'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        $orders = $query->paginate(20);
        $plans = Plan::all();

        return view('admin.sales', compact('orders', 'plans'));
    }
}
