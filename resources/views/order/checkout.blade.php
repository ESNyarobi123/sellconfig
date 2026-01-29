@extends('layouts.app')

@section('title', 'Malipo - ' . $plan->name)

@section('content')
    <div class="container">
        <div class="auth-container">
            <div class="auth-card" style="max-width: 500px;">
                <div class="auth-header">
                    <h1 class="auth-title">💳 Malipo</h1>
                    <p class="auth-subtitle">Weka namba ya M-Pesa/Tigo Pesa kwa malipo</p>
                </div>

                <div class="order-summary"
                    style="background: var(--bg-tertiary); padding: var(--spacing-lg); border-radius: var(--radius-md); margin-bottom: var(--spacing-xl);">
                    <h3 style="margin-bottom: var(--spacing-md); color: var(--accent-primary);">📦 Muhtasari wa Order</h3>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span class="text-muted">Plan:</span>
                        <strong>{{ $plan->name }}</strong>
                    </div>
                    @if($plan->duration)
                        <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                            <span class="text-muted">Muda:</span>
                            <span>{{ $plan->duration }}</span>
                        </div>
                    @endif
                    <div
                        style="display: flex; justify-content: space-between; border-top: 1px solid rgba(102, 252, 241, 0.2); padding-top: var(--spacing-md); margin-top: var(--spacing-md);">
                        <span class="text-muted">Jumla:</span>
                        <strong style="color: var(--accent-primary); font-size: 1.25rem;">TZS
                            {{ number_format($plan->price, 0) }}</strong>
                    </div>
                </div>

                <form action="{{ route('plan.purchase', $plan) }}" method="POST" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="payment_phone">
                            📱 Namba ya Malipo (M-Pesa/Tigo Pesa)
                        </label>
                        <input type="tel" id="payment_phone" name="payment_phone" class="form-input"
                            value="{{ old('payment_phone', auth()->user()->phone) }}" placeholder="0712345678" required
                            pattern="0[0-9]{9}" maxlength="10">
                        @error('payment_phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        <small class="text-muted" style="display: block; margin-top: var(--spacing-xs);">
                            Utapokea ombi la USSD Push kwenye namba hii. Ingiza PIN yako kukamilisha malipo.
                        </small>
                    </div>

                    <div class="form-group"
                        style="background: rgba(102, 252, 241, 0.1); padding: var(--spacing-md); border-radius: var(--radius-md); border-left: 3px solid var(--accent-primary);">
                        <p style="margin: 0; font-size: 0.875rem;">
                            <strong>📌 Maelekezo:</strong><br>
                            1. Weka namba sahihi ya M-Pesa au Tigo Pesa<br>
                            2. Bofya "Lipa Sasa"<br>
                            3. Utapokea USSD Push kwenye simu yako<br>
                            4. Ingiza PIN yako kukamilisha
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <span>💳</span>
                        Lipa Sasa - TZS {{ number_format($plan->price, 0) }}
                    </button>
                </form>

                <div style="text-align: center; margin-top: var(--spacing-lg);">
                    <a href="{{ route('home') }}" class="btn btn-secondary" style="width: auto; display: inline-block;">
                        ⬅️ Rudi Nyuma
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection