@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', '📊 Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-value">TZS {{ number_format($stats['total_sales'], 0) }}</div>
        <div class="stat-label">Total Sales</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
        <div class="stat-label">Total Orders</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🔐</div>
        <div class="stat-value">{{ $stats['available_configs'] }}</div>
        <div class="stat-label">Available Configs</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-value">{{ $stats['sold_configs'] }}</div>
        <div class="stat-label">Sold Configs</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total Users</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-value">{{ $stats['total_plans'] }}</div>
        <div class="stat-label">Total Plans</div>
    </div>
</div>

<!-- HarakaPay Balance -->
@if(isset($balance['success']) && $balance['success'])
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">💳 HarakaPay Balance</h3>
    </div>
    <div class="admin-card-body">
        <div class="stats-grid" style="margin-bottom: 0;">
            <div class="stat-card">
                <div class="stat-icon">💵</div>
                <div class="stat-value">TZS {{ number_format($balance['wallet_balance'] ?? 0, 0) }}</div>
                <div class="stat-label">Wallet Balance</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏦</div>
                <div class="stat-value">TZS {{ number_format($balance['float_balance'] ?? 0, 0) }}</div>
                <div class="stat-label">Float Balance</div>
            </div>
        </div>
    </div>
</div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--spacing-xl);">
    <!-- Recent Orders -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">🛒 Recent Orders</h3>
            <a href="{{ route('admin.sales') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ $order->plan->name ?? 'N/A' }}</td>
                                <td>TZS {{ number_format($order->amount, 0) }}</td>
                                <td>
                                    @switch($order->payment_status)
                                        @case('completed')
                                            <span class="status-badge status-completed">Paid</span>
                                            @break
                                        @case('pending')
                                        @case('processing')
                                            <span class="status-badge status-pending">Pending</span>
                                            @break
                                        @default
                                            <span class="status-badge status-failed">Failed</span>
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Top Plans -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">🏆 Top Selling Plans</h3>
            <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary btn-sm">Manage</a>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPlans as $plan)
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td>TZS {{ number_format($plan->price, 0) }}</td>
                                <td>{{ $plan->orders_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No plans yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">⚡ Quick Actions</h3>
    </div>
    <div class="admin-card-body">
        <div class="action-buttons">
            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary" style="width: auto;">
                ➕ Add New Plan
            </a>
            <a href="{{ route('admin.configs.create') }}" class="btn btn-secondary" style="width: auto;">
                📤 Upload Configs
            </a>
            <a href="{{ route('admin.settings') }}" class="btn btn-secondary" style="width: auto;">
                ⚙️ Settings
            </a>
        </div>
    </div>
</div>
@endsection
