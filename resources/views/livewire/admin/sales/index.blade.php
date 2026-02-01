@section('title', 'Sales History')
@section('header', '💰 Sales History')

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">All Orders</h3>
    </div>
    <div class="admin-card-body">
        <!-- Filters -->
        <div class="grid-2" style="margin-bottom: 2rem; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Filter by Status</label>
                <select wire:model.live="filterStatus" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="completed">Paid (Completed)</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Filter by Plan</label>
                <select wire:model.live="filterPlan" class="form-select">
                    <option value="">All Plans</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Config Sent</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr wire:key="order-{{ $order->id }}">
                            <td>#{{ $order->id }}</td>
                            <td>
                                <div>{{ $order->user->name ?? 'Deleted User' }}</div>
                                <small class="text-muted">{{ $order->user->phone ?? '' }}</small>
                            </td>
                            <td>{{ $order->plan->name ?? 'N/A' }}</td>
                            <td>TZS {{ number_format($order->amount, 0) }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                            <td>
                                @if($order->config)
                                    <span class="status-badge status-completed">✅ Yes</span>
                                @else
                                    <span class="text-muted">No</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 2rem;">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="pagination" style="margin-top: 1rem;">
            {{ $orders->links() }}
        </div>
    </div>
</div>
