@extends('layouts.app')

@section('title', $plan->name)

@section('content')
    <div class="container">
        <div class="auth-container" style="padding-top: 0;">
            <div class="auth-card" style="max-width: 600px;">
                @if($plan->image)
                    <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->name }}"
                        style="width: 100%; height: 200px; object-fit: cover; border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                @else
                    <div
                        style="height: 150px; display: flex; align-items: center; justify-content: center; font-size: 4rem; background: var(--bg-tertiary); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                        📡
                    </div>
                @endif

                <h1 style="font-family: var(--font-display); margin-bottom: var(--spacing-sm);">{{ $plan->name }}</h1>

                @if($plan->duration)
                    <span class="plan-duration">{{ $plan->duration }}</span>
                @endif

                <p style="color: var(--text-secondary); margin: var(--spacing-lg) 0;">
                    {{ $plan->description ?? 'VPN config ya kuaminika na ya haraka.' }}
                </p>

                <div class="plan-price" style="margin-bottom: var(--spacing-lg);">
                    TZS {{ number_format($plan->price, 0, '.', ',') }}
                    <span>/ config</span>
                </div>

                <div class="plan-stock" style="margin-bottom: var(--spacing-xl);">
                    @if($plan->available_count > 0)
                        <span class="stock-indicator available"></span>
                        <span class="stock-text">Stock:</span>
                        <span class="stock-count">{{ $plan->available_count }} zinapatikana</span>
                    @else
                        <span class="stock-indicator out"></span>
                        <span class="stock-text stock-out">Zimeisha</span>
                    @endif
                </div>

                @if($plan->available_count > 0)
                    <form action="{{ route('plan.purchase', $plan) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <span>🛒</span>
                            Nunua Sasa - TZS {{ number_format($plan->price, 0) }}
                        </button>
                    </form>
                @else
                    <button class="btn btn-primary" disabled>
                        <span>❌</span>
                        Imeisha Stock
                    </button>
                @endif

                <div style="margin-top: var(--spacing-xl);">
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        ⬅️ Rudi Nyumbani
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection