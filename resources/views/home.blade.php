@extends('layouts.app')

@section('title', 'Nyumbani')

@section('content')
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <h1 class="hero-title">⚡ Premium VPN Configs</h1>
            <p class="hero-subtitle">
                Pata VPN configs za kuaminika kwa bei nafuu. Mfumo wa automatiki - ukilipa unapata mara moja!
            </p>
            <div class="hero-badges">
                <span class="badge">
                    <span class="badge-icon">🚀</span>
                    Haraka
                </span>
                <span class="badge">
                    <span class="badge-icon">🔒</span>
                    Salama
                </span>
                <span class="badge">
                    <span class="badge-icon">💰</span>
                    Bei Nafuu
                </span>
                <span class="badge">
                    <span class="badge-icon">📱</span>
                    24/7 Support
                </span>
            </div>
        </section>

        <!-- Plans Section -->
        <section>
            <h2 class="section-title">📦 Chagua Plan Yako</h2>

            @if($plans->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3 class="empty-title">Hakuna Plans Kwa Sasa</h3>
                    <p class="empty-text">Tafadhali rudi baadaye. Tunaandaa plans mpya.</p>
                </div>
            @else
                <div class="plans-grid">
                    @foreach($plans as $plan)
                        <div class="plan-card">
                            @if($plan->image)
                                <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->name }}" class="plan-image">
                            @else
                                <div class="plan-image"
                                    style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                    📡
                                </div>
                            @endif

                            <h3 class="plan-name">{{ $plan->name }}</h3>

                            @if($plan->duration)
                                <span class="plan-duration">{{ $plan->duration }}</span>
                            @endif

                            <p class="plan-description">
                                {{ $plan->description ?? 'VPN config ya kuaminika na ya haraka.' }}
                            </p>

                            <div class="plan-price">
                                TZS {{ number_format($plan->price, 0, '.', ',') }}
                                <span>/ config</span>
                            </div>

                            <div class="plan-stock">
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
                                <a href="{{ route('plan.checkout', $plan) }}" class="btn btn-primary">
                                    <span>🛒</span>
                                    Nunua Sasa
                                </a>
                            @else
                                <button class="btn btn-primary" disabled>
                                    <span>❌</span>
                                    Imeisha Stock
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- How it Works -->
        <section style="margin-top: 4rem;">
            <h2 class="section-title">🎯 Jinsi Inavyofanya Kazi</h2>

            <div class="plans-grid">
                <div class="card" style="text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">1️⃣</div>
                    <h3 style="font-family: var(--font-display); margin-bottom: 0.5rem;">Chagua Plan</h3>
                    <p class="text-muted">Angalia plans zetu na uchague inayokufaa.</p>
                </div>

                <div class="card" style="text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">2️⃣</div>
                    <h3 style="font-family: var(--font-display); margin-bottom: 0.5rem;">Lipa kwa Simu</h3>
                    <p class="text-muted">Utapokea USSD push kwenye simu yako. Thibitisha kulipa.</p>
                </div>

                <div class="card" style="text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">3️⃣</div>
                    <h3 style="font-family: var(--font-display); margin-bottom: 0.5rem;">Pata Config</h3>
                    <p class="text-muted">Mara ukilipa, config yako itaonekana. Copy na uitumie!</p>
                </div>
            </div>
        </section>
    </div>
@endsection