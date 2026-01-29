@extends('layouts.admin')

@section('title', 'Sales History')
@section('header', '💰 Sales History')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">💰 All Orders</h3>
    </div>
    <div class="admin-card-body">
        <!-- Filters -->
        <form action="{{ route('admin.sales') }}" method="GET">
            <div class="filter-bar">
                <select name="status" class="form-input form-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                
                <select name="plan_id" class="form-input form-select" onchange="this.form.submit()">
                    <option value="">All Plans</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
                
                @if(request()->filled('status') || request()->filled('plan_id'))
                    <a href="{{ route('admin.sales') }}" class="btn btn-secondary btn-sm" style="width: auto;">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->user->phone ?? 'N/A' }}</td>
                        <td>{{ $order->plan->name ?? 'N/A' }}</td>
                        <td>TZS {{ number_format($order->amount, 0) }}</td>
                        <td>
                            @switch($order->payment_status)
                                @case('completed')
                                    <span class="status-badge status-completed">Paid</span>
                                    @break
                                @case('pending')
                                    <span class="status-badge status-pending">Pending</span>
                                    @break
                                @case('processing')
                                    <span class="status-badge status-pending">Processing</span>
                                    @break
                                @default
                                    <span class="status-badge status-failed">Failed</span>
                            @endswitch
                        </td>
                        <td>
                            @switch($order->order_status)
                                @case('delivered')
                                    <span class="status-badge status-completed">Delivered</span>
                                    @break
                                @case('paid')
                                    <span class="status-badge status-pending">Paid</span>
                                    @break
                                @default
                                    <span class="status-badge status-failed">{{ ucfirst($order->order_status) }}</span>
                            @endswitch
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No orders found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: var(--spacing-lg);">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
