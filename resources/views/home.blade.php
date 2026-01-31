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
                <div class="plan-card" style="border-color: var(--primary-color);">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">🟢</div>
                    <h3 style="color: var(--accent-primary); font-size: 1.1rem; text-align: center;">HALOTEL UNLIMITED</h3>
                    <p style="font-weight: bold; font-size: 0.8rem; text-align: center; margin-bottom: 0.5rem;">VPN: HTTP
                        INJECTOR</p>
                    <p class="text-muted" style="font-size: 0.75rem; text-align: center; flex-grow: 1;">
                        Kama umedownload Play Store, futa na u-install hii ya kwetu.
                    </p>
                    <a href="https://uploadapk.store/view-app.php?id=226" target="_blank" class="btn btn-primary"
                        style="margin-top: 1rem;">
                        <span>⬇️</span> Download
                    </a>
                </div>

                <!-- Airtel App -->
                <div class="plan-card" style="border-color: #ff4500;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">🔴</div>
                    <h3 style="color: #ff4500; font-size: 1.1rem; text-align: center;">AIRTEL VPN</h3>
                    <p style="font-weight: bold; font-size: 0.8rem; text-align: center; margin-bottom: 0.5rem;">HTTP CUSTOM
                    </p>
                    <p class="text-muted" style="font-size: 0.75rem; text-align: center; flex-grow: 1;">
                        Bonyeza hapa kupata file la Airtel.
                    </p>
                    <a href="#" class="btn btn-primary"
                        style="background-color: #ff4500; border-color: #ff4500; margin-top: 1rem;">
                        <span>⬇️</span> Download
                    </a>
                </div>
            </div>
        </section>

        <!-- Plans Section -->
        <section>
            <h2 class="section-title">📦 Chagua Plan Yako</h2>


            <!-- Tabs -->
            <div class="tabs-container" style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem;">
                <button class="tab-btn active" onclick="filterPlans('weekly', this)">
                    📅 WEEKLY
                </button>
                <button class="tab-btn" onclick="filterPlans('bi_weekly', this)">
                    📅 2 WEEKLY
                </button>
                <button class="tab-btn" onclick="filterPlans('monthly', this)">
                    📅 30 DAYS
                </button>
            </div>

            @if($plans->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3 class="empty-title">Hakuna Plans Kwa Sasa</h3>
                    <p class="empty-text">Tafadhali rudi baadaye. Tunaandaa plans mpya.</p>
                </div>
            @else
                <div class="plans-grid">
                    @foreach($plans as $plan)
                        <div class="plan-card" data-type="{{ $plan->type ?? 'weekly' }}">
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
                                <span style="font-size: 0.8rem; color: var(--text-muted);">TZS</span>
                                {{ number_format($plan->price, 0, '.', ',') }}
                                <span style="font-size: 0.7rem;">/ config</span>
                            </div>

                            <div class="plan-stock">
                                @if($plan->available_count > 0)
                                    <span class="stock-indicator available"></span>
                                    <span class="stock-count">{{ $plan->available_count }} in stock</span>
                                @else
                                    <span class="stock-indicator out"></span>
                                    <span class="stock-text stock-out">Zimeisha</span>
                                @endif
                            </div>

                            @if($plan->available_count > 0)
                                <a href="{{ route('plan.checkout', $plan) }}" class="btn btn-primary">
                                    <span>🛒</span> Nunua
                                </a>
                            @else
                                <button class="btn btn-primary" disabled>
                                    <span>❌</span> Imeisha
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <style>
                .tab-btn {
                    background: transparent;
                    border: 1px solid var(--accent-primary);
                    color: var(--accent-primary);
                    padding: 0.5rem 1.5rem;
                    border-radius: 9999px;
                    cursor: pointer;
                    font-family: var(--font-display);
                    font-weight: 500;
                    transition: all 0.3s ease;
                }

                .tab-btn:hover {
                    background: rgba(102, 252, 241, 0.1);
                }

                .tab-btn.active {
                    background: var(--accent-gradient);
                    color: var(--bg-primary);
                    border-color: transparent;
                    box-shadow: 0 0 15px rgba(102, 252, 241, 0.5);
                }

                .plan-card.hidden {
                    display: none !important;
                }
            </style>

            <script>
                function filterPlans(type, btn) {
                    // Update buttons
                    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                    if (btn) btn.classList.add('active');

                    // Filter cards
                    const cards = document.querySelectorAll('.plan-card[data-type]');
                    let hasVisible = false;

                    cards.forEach(card => {
                        if (card.dataset.type === type) {
                            card.classList.remove('hidden');
                            hasVisible = true;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    // Handle empty state if needed (optional)
                }

                // Initialize
                document.addEventListener('DOMContentLoaded', () => {
                    filterPlans('weekly', document.querySelector('.tab-btn'));
                });
            </script>
        </section>
    </div>
@endsection