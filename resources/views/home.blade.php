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
                <a href="{{ $whatsappLink ?? 'https://wa.me/260966122504' }}" class="badge"
                    style="text-decoration: none; color: inherit;">
                    <span class="badge-icon">📞</span>
                    WhatsApp Msaada
                </a>
                <a href="{{ $youtubeLink ?? 'https://www.youtube.com/@CyberHunter-b6n3t' }}" class="badge"
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
                @php
                    $halotelLink = \App\Models\Setting::get('app_halotel_link', 'https://uploadapk.store/view-app.php?id=226');
                    $airtelLink = \App\Models\Setting::get('app_airtel_link', '#');
                    $whatsappLink = \App\Models\Setting::get('whatsapp_link', 'https://wa.me/260966122504');
                    $youtubeLink = \App\Models\Setting::get('youtube_link', 'https://www.youtube.com/@CyberHunter-b6n3t');
                @endphp

                <div class="plan-card" style="border-color: var(--primary-color);">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;">🟢</div>
                    <h3 style="color: var(--accent-primary); font-size: 1.1rem; text-align: center;">HALOTEL UNLIMITED</h3>
                    <p style="font-weight: bold; font-size: 0.8rem; text-align: center; margin-bottom: 0.5rem;">VPN: HTTP
                        INJECTOR</p>
                    <p class="text-muted" style="font-size: 0.75rem; text-align: center; flex-grow: 1;">
                        Kama umedownload Play Store, futa na u-install hii ya kwetu.
                    </p>
                    <a href="{{ $halotelLink }}" target="_blank" class="btn btn-primary" style="margin-top: 1rem;">
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
                    <a href="{{ $airtelLink }}" target="_blank" class="btn btn-primary"
                        style="background-color: #ff4500; border-color: #ff4500; margin-top: 1rem;">
                        <span>⬇️</span> Download
                    </a>
                </div>
            </div>
        </section>

        <!-- Plans Section -->
        <!-- Plans Section -->
        <section>
            <h2 class="section-title">📦 Chagua Plan Yako</h2>

            <!-- Tabs -->
            <div class="tabs-container"
                style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
                <a href="{{ route('home', ['tab' => 'week_1']) }}"
                    class="tab-btn {{ $activeTab === 'week_1' ? 'active' : '' }}"
                    style="text-decoration: none; display: inline-block; text-align: center;">
                    📅 1 WEEK
                </a>
                <a href="{{ route('home', ['tab' => 'week_2']) }}"
                    class="tab-btn {{ $activeTab === 'week_2' ? 'active' : '' }}"
                    style="text-decoration: none; display: inline-block; text-align: center;">
                    📅 2 WEEKS
                </a>
                <a href="{{ route('home', ['tab' => 'month_1']) }}"
                    class="tab-btn {{ $activeTab === 'month_1' ? 'active' : '' }}"
                    style="text-decoration: none; display: inline-block; text-align: center;">
                    📅 1 MONTH (30 Days)
                </a>
                <a href="{{ route('home', ['tab' => 'other']) }}"
                    class="tab-btn {{ $activeTab === 'other' ? 'active' : '' }}"
                    style="text-decoration: none; display: inline-block; text-align: center;">
                    📂 OTHER
                </a>
            </div>

            <!-- Plans Grid -->
            <div>
                @if($plans->isEmpty())
                    <div class="empty-state" style="text-align: center; padding: 3rem;">
                        <div class="empty-icon" style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                        <h3 class="empty-title" style="color: var(--text-primary);">Hakuna Plans Kwa Group Hii</h3>
                        <p class="empty-text" style="color: var(--text-secondary);">Tafadhali chagua group lingine.</p>
                    </div>
                @else
                    <div class="plans-grid">
                        @foreach($plans as $plan)
                            <div class="plan-card blue-theme">
                                @if($plan->image)
                                    <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->name }}" class="plan-image">
                                @else
                                    <div class="plan-image"
                                        style="display: flex; align-items: center; justify-content: center; font-size: 3rem; background: rgba(255,255,255,0.5);">
                                        📡
                                    </div>
                                @endif

                                <h3 class="plan-name" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                    {{ $plan->name }}
                                </h3>

                                @if($plan->duration)
                                    <span class="plan-duration"
                                        style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.3);">{{ $plan->duration }}</span>
                                @endif

                                <p class="plan-description" style="color: #e2e8f0;">
                                    {{ $plan->description ?? 'VPN config ya kuaminika na ya haraka.' }}
                                </p>

                                <div class="plan-price">
                                    <span style="font-size: 0.8rem; color: #cbd5e1;">TZS</span>
                                    <span
                                        style="color: #60a5fa; font-weight: 800; text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);">{{ number_format((float) $plan->price, 0, '.', ',') }}</span>
                                    <span style="font-size: 0.7rem; color: #cbd5e1;">/ config</span>
                                </div>

                                <div class="plan-stock">
                                    @if($plan->available_count > 0)
                                        <span class="stock-indicator available"
                                            style="background: #4ade80; box-shadow: 0 0 10px #4ade80;"></span>
                                        <span class="stock-count" style="color: #4ade80;">{{ $plan->available_count }} in
                                            stock</span>
                                    @else
                                        <span class="stock-indicator out"></span>
                                        <span class="stock-text stock-out" style="color: #f87171;">Zimeisha</span>
                                    @endif
                                </div>

                                @if($plan->available_count > 0)
                                    <a href="{{ route('plan.checkout', $plan) }}" class="btn btn-primary"
                                        style="background: linear-gradient(to right, #2563eb, #1d4ed8); border: none; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                                        <span>🛒</span> Nunua
                                    </a>
                                @else
                                    <button class="btn btn-primary" disabled
                                        style="background: #cbd5e0; border: none; cursor: not-allowed;">
                                        <span>❌</span> Imeisha
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <style>
                /* AMAZING BLUE THEME - RESPONSIVE & COMPACT */

                /* Responsive Grid System */
                .plans-grid {
                    display: grid !important;
                    /* Mobile First: 2 columns by default on very small screens, then auto-fill */
                    grid-template-columns: repeat(2, 1fr) !important;
                    gap: 8px !important;
                    padding: 0 4px !important;
                }

                @media (min-width: 600px) {
                    .plans-grid {
                        /* Tablet & Up: Adaptive based on space */
                        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)) !important;
                        gap: 12px !important;
                        padding: 0 10px !important;
                    }
                }

                @media (min-width: 1024px) {
                    .plans-grid {
                        /* Desktop: Slightly larger spacing */
                        gap: 16px !important;
                    }
                }

                .plan-card,
                .plan-card.blue-theme {
                    background: linear-gradient(135deg, #001e4d 0%, #004e92 100%) !important;
                    border: 1px solid rgba(100, 200, 255, 0.2) !important;
                    border-radius: 12px !important;
                    /* Smaller radius */
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4), inset 0 0 0 1px rgba(255, 255, 255, 0.1) !important;
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    padding: 0.75rem !important;
                    /* Reduced padding significantly */
                    position: relative;
                    overflow: hidden;
                    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
                }

                /* Shiny Glass Effect Overlay */
                .plan-card::after {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.01) 100%);
                    z-index: 0;
                    pointer-events: none;
                }

                .plan-card:hover {
                    transform: translateY(-4px) scale(1.02) !important;
                    box-shadow: 0 8px 20px rgba(0, 80, 255, 0.4) !important;
                    border-color: #66FCF1 !important;
                    background: linear-gradient(135deg, #003366 0%, #0059b3 100%) !important;
                    z-index: 10;
                }

                /* Content Styling */
                .plan-card * {
                    position: relative;
                    z-index: 1;
                }

                .plan-name {
                    font-size: 0.9rem !important;
                    /* Smaller Title */
                    font-weight: 700 !important;
                    letter-spacing: 0.5px;
                    color: #fff !important;
                    text-transform: uppercase;
                    margin-bottom: 0.4rem !important;
                    text-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
                    line-height: 1.2;
                }

                .plan-image {
                    background: rgba(255, 255, 255, 0.1) !important;
                    border-radius: 8px !important;
                    margin-bottom: 0.5rem !important;
                    height: 50px !important;
                    /* Smaller Height */
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                }

                /* Icon/Emoji size in App Download cards */
                .plan-card div[style*="font-size: 2.5rem"] {
                    font-size: 2rem !important;
                    /* Smaller Emoji */
                    margin-bottom: 0.25rem !important;
                }

                .plan-description {
                    font-size: 0.65rem !important;
                    /* Smaller description */
                    line-height: 1.2;
                    margin-bottom: 0.5rem !important;
                    color: #bae6fd !important;
                    /* Nice Light Cyan for Readability */
                    font-weight: 500;
                    opacity: 0.9;
                }

                .plan-stock {
                    font-size: 0.6rem !important;
                    margin-bottom: 0.4rem !important;
                }

                .stock-indicator {
                    width: 6px !important;
                    height: 6px !important;
                }

                .plan-price {
                    font-size: 1.1rem !important;
                    /* Smaller Price */
                    color: #66FCF1 !important;
                    text-shadow: 0 0 10px rgba(102, 252, 241, 0.6);
                    font-weight: 800 !important;
                    margin: 0.5rem 0 !important;
                }

                .plan-price span {
                    font-size: 0.7rem !important;
                    color: rgba(255, 255, 255, 0.8) !important;
                }

                /* Button Upgrade - Compact */
                .btn-primary {
                    background: linear-gradient(90deg, #00C6FF 0%, #0072FF 100%) !important;
                    border: none !important;
                    font-weight: bold !important;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    box-shadow: 0 2px 8px rgba(0, 114, 255, 0.4) !important;
                    padding: 0.4rem 0.8rem !important;
                    /* Smaller padding */
                    font-size: 0.8rem !important;
                    /* Smaller text */
                    min-height: auto !important;
                }

                .btn-primary:hover {
                    box-shadow: 0 4px 12px rgba(0, 198, 255, 0.6) !important;
                    transform: translateY(-1px);
                }

                /* Tabs Styling */
                .tab-btn {
                    background: rgba(0, 30, 80, 0.6);
                    border: 1px solid rgba(102, 252, 241, 0.3);
                    color: rgba(255, 255, 255, 0.7);
                    padding: 0.5rem 1rem;
                    /* Smaller tabs */
                    font-size: 0.85rem;
                    border-radius: 50px;
                    cursor: pointer;
                    font-family: var(--font-display);
                    font-weight: 600;
                    transition: all 0.3s ease;
                    backdrop-filter: blur(5px);
                }

                .tab-btn:hover {
                    background: rgba(102, 252, 241, 0.2);
                    color: #fff;
                    transform: translateY(-2px);
                }

                .tab-btn.active {
                    background: linear-gradient(90deg, #00C6FF 0%, #0072FF 100%);
                    color: white !important;
                    /* Fixed visibility on active */
                    border-color: transparent;
                    box-shadow: 0 0 20px rgba(0, 114, 255, 0.5);
                }
            </style>
        </section>
    </div>
@endsection