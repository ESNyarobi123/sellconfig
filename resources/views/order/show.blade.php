@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container">
    <div class="auth-container" style="padding-top: 0;">
        <div class="auth-card" style="max-width: 600px;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-family: var(--font-display);">📦 Order #{{ $order->id }}</h1>
            </div>
            
            <div style="padding: 1rem; background: rgba(102, 252, 241, 0.1); border-radius: 8px; margin-bottom: 2rem;">
                <p style="margin-bottom: 0.5rem;"><strong>📦 Plan:</strong> {{ $order->plan->name }}</p>
                <p style="margin-bottom: 0.5rem;"><strong>💰 Kiasi:</strong> TZS {{ number_format($order->amount, 0) }}</p>
                <p style="margin-bottom: 0.5rem;">
                    <strong>📊 Hali:</strong> 
                    @switch($order->order_status)
                        @case('delivered')
                            <span class="status-badge status-completed">✅ Imetolewa</span>
                            @break
                        @case('paid')
                            <span class="status-badge status-pending">⏳ Inasubiri</span>
                            @break
                        @default
                            <span class="status-badge status-failed">❌ Imeghairiwa</span>
                    @endswitch
                </p>
                <p style="margin-bottom: 0;"><strong>📅 Tarehe:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            @if($order->config && $order->order_status === 'delivered')
                <h3 style="font-family: var(--font-display); margin-bottom: 1rem;">🔐 Config Yako</h3>
                
                <div class="config-box" id="configBox">
                    <button class="copy-btn" onclick="copyConfig()" id="copyBtn">
                        📋 Copy
                    </button>
                    <pre class="config-content" id="configContent">{{ $order->config->content }}</pre>
                </div>
            @endif
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="{{ route('history') }}" class="btn btn-secondary">
                    ⬅️ Rudi Historia
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    🏠 Nyumbani
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyConfig() {
        const content = document.getElementById('configContent').textContent;
        const btn = document.getElementById('copyBtn');
        
        navigator.clipboard.writeText(content).then(() => {
            btn.textContent = '✅ Copied!';
            btn.classList.add('copied');
            
            setTimeout(() => {
                btn.textContent = '📋 Copy';
                btn.classList.remove('copied');
            }, 2000);
        }).catch(err => {
            const textarea = document.createElement('textarea');
            textarea.value = content;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            
            btn.textContent = '✅ Copied!';
            btn.classList.add('copied');
            
            setTimeout(() => {
                btn.textContent = '📋 Copy';
                btn.classList.remove('copied');
            }, 2000);
        });
    }
</script>
@endpush
