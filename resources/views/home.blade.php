@extends('layouts.app')

@section('title', 'Nyumbani')

@section('content')
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <h1 class="hero-title">CYBER HUNTER ONLINE 🟢 CLOUD</h1>
            <p class="hero-subtitle">
                JIpatie config kwa Bei rahis kwa matumiz ya kawaida huku ukishinda online masaa 24 utapata cloud config kwa
                mitandao mbal mbal nchi tanzania ila kwa Sasa huduma YETU inatokana cloud za mtandao wa HALOTEL na files za
                Airtel tu
            </p>
            <div class="hero-badges">
                <a href="https://wa.me/260966122504" class="badge" style="text-decoration: none; color: inherit;">
                    <span class="badge-icon">📞</span>
                    WhatsApp Msaada
                </a>
                <a href="https://www.youtube.com/@CyberHunter-b6n3t" class="badge"
                    style="text-decoration: none; color: inherit;">
                    <span class="badge-icon">📺</span>
                    Youtube Channel
                </a>
            </div>
        </section>

        <!-- Apps Download Section -->
        <section style="margin-bottom: 3rem;">
            <h2 class="section-title">📲 Download Apps</h2>

            <div class="plans-grid">
                <!-- Halotel App -->
                <div class="card" style="text-align: center; border: 1px solid var(--primary-color);">
                    <h3 style="color: var(--primary-color);">HALOTEL UNLIMITED</h3>
                    <p style="font-weight: bold;">VPN: HTTP INJECTOR</p>
                    <p class="text-muted" style="font-size: 0.9rem;">
                        Kama umedownload Play Store, futa na u-install hii ya kwetu. Ikigoma wasiliana nasi.
                    </p>
                    <a href="https://uploadapk.store/view-app.php?id=226" target="_blank" class="btn btn-primary"
                        style="width: 100%; margin-top: 1rem;">
                        <span>⬇️</span> Download HTTP Injector
                    </a>
                </div>

                <!-- Airtel App -->
                <div class="card" style="text-align: center; border: 1px solid #ff4500;"> <!-- Airtel red-ish color -->
                    <h3 style="color: #ff4500;">AIRTEL VPN</h3>
                    <p style="font-weight: bold;">HTTP CUSTOM</p>
                    <p class="text-muted" style="font-size: 0.9rem;">
                        Bonyeza hapa kupata file la Airtel.
                    </p>
                    <a href="#" class="btn btn-primary"
                        style="background-color: #ff4500; border-color: #ff4500; width: 100%; margin-top: 1rem;">
                        <span>⬇️</span> Download HTTP Custom
                    </a>
                </div>
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
    </div>
@endsection