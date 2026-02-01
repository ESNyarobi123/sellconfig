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
                @php
                    $halotelLink = \App\Models\Setting::get('app_halotel_link', 'https://uploadapk.store/view-app.php?id=226');
                    $airtelLink = \App\Models\Setting::get('app_airtel_link', '#');
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

            <livewire:plan-list />
        </section>
    </div>
@endsection