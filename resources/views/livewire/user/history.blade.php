<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">📦 Historia ya Manunuzi</h1>
        </div>
        
        @if($orders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🛒</div>
                <h3 class="empty-title">Hakuna Manunuzi</h3>
                <p class="empty-text">Bado hujafanya manunuzi yoyote. Anza sasa!</p>
                <a href="{{ route('home') }}" class="btn btn-primary" style="width: auto;" wire:navigate>
                    <span>🏠</span>
                    Angalia Plans
                </a>
            </div>
        @else
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Plan</th>
                            <th>Kiasi</th>
                            <th>Hali</th>
                            <th>Tarehe</th>
                            <th>Kitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr wire:key="order-{{ $order->id }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->plan->name ?? 'N/A' }}</td>
                                <td>TZS {{ number_format($order->amount, 0) }}</td>
                                <td>
                                    @switch($order->order_status)
                                        @case('delivered')
                                            <span class="status-badge status-completed">✅ Imetolewa</span>
                                            @break
                                        @case('paid')
                                            <span class="status-badge status-pending">⏳ Inasubiri</span>
                                            @break
                                        @case('cancelled')
                                            <span class="status-badge status-failed">❌ Imeghairiwa</span>
                                            @break
                                        @default
                                            <span class="status-badge status-pending">⏳ Inasubiri</span>
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($order->order_status === 'delivered')
                                        <a href="{{ route('order.show', $order) }}" class="btn btn-secondary btn-sm" wire:navigate>
                                            👁️ Angalia
                                        </a>
                                    @elseif($order->payment_status === 'processing')
                                        <a href="{{ route('order.waiting', $order) }}" class="btn btn-primary btn-sm" wire:navigate>
                                            ⏳ Subiri
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
