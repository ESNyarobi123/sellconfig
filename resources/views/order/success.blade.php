@extends('layouts.app')

@section('title', 'Umefanikiwa!')

@section('content')
<div class="container">
    <div class="auth-container" style="padding-top: 0;">
        <div class="auth-card" style="max-width: 600px;">
            <div style="text-align: center;">
                <div style="font-size: 5rem; margin-bottom: 1rem; animation: bounce 0.5s ease;">🎉</div>
                <h1 style="font-family: var(--font-display); color: var(--success); margin-bottom: 0.5rem;">
                    Hongera! Umefanikiwa!
                </h1>
                <p class="text-muted">Config yako iko hapa chini. Inakili na uitumie.</p>
            </div>
            
            <div style="margin-top: 2rem; padding: 1rem; background: rgba(102, 252, 241, 0.1); border-radius: 8px;">
                <p style="margin-bottom: 0.5rem;"><strong>📦 Plan:</strong> {{ $order->plan->name }}</p>
                <p style="margin-bottom: 0.5rem;"><strong>💰 Kiasi:</strong> TZS {{ number_format($order->amount, 0) }}</p>
                <p style="margin-bottom: 0;"><strong>📅 Tarehe:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            @if($order->config)
                <div class="config-box" id="configBox">
                    <button class="copy-btn" onclick="copyConfig()" id="copyBtn">
                        📋 Copy
                    </button>
                    <pre class="config-content" id="configContent">{{ $order->config->content }}</pre>
                </div>
                
                <p class="text-center text-muted" style="font-size: 0.875rem;">
                    💡 Config hii imehifadhiwa. Unaweza kuiona tena kwenye <a href="{{ route('history') }}" style="color: var(--accent-primary);">Historia</a>.
                </p>
            @else
                <div class="alert alert-error" style="position: relative; top: 0; right: 0; margin-top: 2rem;">
                    <span class="alert-icon">❌</span>
                    Kuna tatizo kupata config yako. Tafadhali wasiliana na support.
                </div>
            @endif
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    🏠 Nyumbani
                </a>
                <a href="{{ route('history') }}" class="btn btn-primary">
                    📦 Historia
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
</style>
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
            // Fallback for older browsers
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
