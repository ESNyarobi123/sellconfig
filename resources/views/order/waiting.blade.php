@extends('layouts.app')

@section('title', 'Inasubiri Malipo')

@section('content')
    <div class="container">
        <div class="auth-container" style="padding-top: 0;">
            <div class="auth-card" style="max-width: 500px;">
                <div class="loading-container">
                    <div class="loading-spinner"></div>
                    <h2 style="font-family: var(--font-display); margin-bottom: 1rem;">⏳ Inasubiri Malipo...</h2>
                    <p class="loading-text" id="statusMessage">Tafadhali thibitisha malipo kwenye simu yako.</p>

                    <div style="margin-top: 2rem; padding: 1rem; background: rgba(102, 252, 241, 0.1); border-radius: 8px;">
                        <p style="margin-bottom: 0.5rem;"><strong>Plan:</strong> {{ $order->plan->name }}</p>
                        <p style="margin-bottom: 0.5rem;"><strong>Kiasi:</strong> TZS {{ number_format($order->amount, 0) }}
                        </p>
                        <p style="margin-bottom: 0;"><strong>Order ID:</strong> {{ $order->payment_order_id }}</p>
                    </div>

                    <div style="margin-top: 2rem;">
                        <p class="text-muted" style="font-size: 0.875rem;">
                            💡 Ukishindwa kupokea USSD, jaribu tena au wasiliana na support.
                        </p>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            ❌ Ghairi na Rudi Nyumbani
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const orderId = {{ $order->id }};
        const statusUrl = "{{ route('order.status', $order) }}";
        let pollCount = 0;
        const maxPolls = 120; // 10 minutes (5 seconds * 120)

        function checkPaymentStatus() {
            pollCount++;

            if (pollCount > maxPolls) {
                document.getElementById('statusMessage').textContent = 'Muda umekwisha. Tafadhali jaribu tena.';
                document.querySelector('.loading-spinner').style.display = 'none';
                return;
            }

            fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'completed') {
                        document.getElementById('statusMessage').textContent = '✅ Malipo yamekamilika! Inapakia config...';
                        document.querySelector('.loading-spinner').style.borderTopColor = '#10B981';
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else if (data.status === 'failed') {
                        document.getElementById('statusMessage').textContent = '❌ ' + data.message;
                        document.querySelector('.loading-spinner').style.display = 'none';
                    } else {
                        document.getElementById('statusMessage').textContent = data.message || 'Inasubiri malipo...';
                        setTimeout(checkPaymentStatus, 5000);
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    setTimeout(checkPaymentStatus, 5000);
                });
        }

        // Start polling after 3 seconds
        setTimeout(checkPaymentStatus, 3000);
    </script>
@endpush