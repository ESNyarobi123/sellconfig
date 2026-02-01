<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Config;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Services\HarakaPayService;

class Dashboard extends Component
{
    public function render()
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
        $balance = ['success' => false];
        try {
            $harakaPay = new HarakaPayService();
            $balance = $harakaPay->getBalance();
        } catch (\Exception $e) {
            // Silently fail if service is not configured or reachable
        }

        // Top selling plans
        $topPlans = Plan::withCount([
            'orders' => function ($query) {
                $query->where('payment_status', 'completed');
            }
        ])->orderByDesc('orders_count')->limit(5)->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'balance' => $balance,
            'topPlans' => $topPlans
        ])->layout('layouts.admin');
    }
}
