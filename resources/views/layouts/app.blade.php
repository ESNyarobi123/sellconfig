<!DOCTYPE html>
<html lang="sw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SellConfig - Pata VPN Configs kwa bei nafuu">
    <title>@yield('title', 'SellConfig') - Premium VPN Configs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('cyberlogo.jpg') }}" type="image/jpeg">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0f172a">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
</head>

<body>
    <!-- ... body content ... -->


    @stack('scripts')
</body>
<!-- Animated Background -->
<div class="cyber-bg">
    <div class="cyber-grid"></div>
    <div class="cyber-glow"></div>
</div>

<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('cyberlogo.jpg') }}" alt="Logo" class="logo-img"
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-primary);">
            <span class="logo-text">CYBER.NET</span>
        </a>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span>
                <span>Nyumbani</span>
            </a>

            <button onclick="requestNotificationPermission()" class="nav-link"
                style="background: none; border: none; cursor: pointer; color: white;">
                <span class="nav-icon">🔔</span>
            </button>

            @auth
                <a href="{{ route('history') }}" class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}">
                    <span class="nav-icon">📦</span>
                    <span>Historia</span>
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link nav-admin">
                        <span class="nav-icon">⚙️</span>
                        <span>Admin</span>
                    </a>
                @endif

                <div class="nav-user">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-logout">Toka</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    <span class="nav-icon">🔑</span>
                    <span>Ingia</span>
                </a>
                <a href="{{ route('register') }}" class="btn-primary-nav">
                    Jiandikishe
                </a>
            @endauth
        </div>

        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('home') }}" class="mobile-link">🏠 Nyumbani</a>
    @auth
        <a href="{{ route('history') }}" class="mobile-link">📦 Historia</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="mobile-link">⚙️ Admin</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="mobile-link logout-btn">🚪 Toka</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="mobile-link">🔑 Ingia</a>
        <a href="{{ route('register') }}" class="mobile-link primary">✨ Jiandikishe</a>
    @endauth
</div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success">
        <span class="alert-icon">✅</span>
        {{ session('success') }}
        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        <span class="alert-icon">❌</span>
        {{ session('error') }}
        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

<!-- Main Content -->
<main class="main-content">
    @if(isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <img src="{{ asset('cyberlogo.jpg') }}" alt="Logo" class="logo-img"
                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-primary); margin-right: 10px;">
                <span>CYBER HUNTER ONLINE</span>
            </div>
            <p class="footer-text">Premium VPN Configs kwa bei nafuu</p>

            <div class="footer-links"
                style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-top: 1rem;">
                <a href="{{ \App\Models\Setting::get('whatsapp_link', 'https://wa.me/260966122504') }}"
                    class="whatsapp-btn" target="_blank"
                    style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <span>💬</span> WhatsApp Msaada
                </a>
                <a href="{{ \App\Models\Setting::get('youtube_link', 'https://www.youtube.com/@CyberHunter-b6n3t') }}"
                    class="youtube-btn" target="_blank"
                    style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; color: #ff0000; background: white; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: bold;">
                    <span>📺</span> Youtube Channel
                </a>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} CYBER.NET SERVICE. Haki zote zimehifadhiwa.</p>
                <!-- <p style="margin-top: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">Developer by <span
                        style="color: var(--accent-primary);">ERICKsky</span></p> -->
            </div>
        </div>
</footer>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('active');
    }

    // Close mobile menu on resize
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            document.getElementById('mobileMenu').classList.remove('active');
        }
    });

    // Auto dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);

    // --- PWA & PUSH NOTIFICATIONS ---

    // Utility to convert VAPID key
    function urlBase64ToUint8Array(base64String) {
        if (!base64String) return null;
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    // Register Service Worker & Subscribe
    const publicVapidKey = "{{ env('VAPID_PUBLIC_KEY') }}";

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').then(function (registration) {
            console.log('Service Worker Registered');
        }).catch(function (err) {
            console.error('SW Error:', err);
        });
    }

    function requestNotificationPermission() {
        if (!publicVapidKey) {
            console.warn('VAPID Key missing, push disabled.');
            return;
        }

        Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
                navigator.serviceWorker.ready.then(function (registration) {
                    const convertedKey = urlBase64ToUint8Array(publicVapidKey);

                    registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: convertedKey
                    }).then(function (subscription) {
                        saveSubscription(subscription);
                        alert('✅ Notifications zimewashwa!');
                    }).catch(function (err) {
                        console.error('Subscription failed:', err);
                    });
                });
            } else {
                alert('Tafadhali ruhusu notifications kwenye browser.');
            }
        });
    }

    function saveSubscription(subscription) {
        fetch('/push/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(subscription)
        }).then(res => console.log('Subscribed!'));
    }
</script>
@stack('scripts')
<!-- PWA Install Modal -->
<div id="pwa-install-modal" class="pwa-modal">
    <div class="pwa-modal-content">
        <div class="pwa-icon-wrapper">
            <img src="{{ asset('cyberlogo.jpg') }}" alt="CyberApp" class="pwa-logo">
        </div>
        <h3>Install Cyber.Net</h3>
        <p>Sasisha App yetu kwenye simu yako kwa experience bora na ya haraka zaidi!</p>
        <div class="pwa-buttons">
            <button id="pwa-dismiss" class="btn-text">Baadaye</button>
            <button id="pwa-install-btn" class="btn-primary">📲 Install App</button>
        </div>
    </div>
</div>

<style>
    .pwa-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: flex-end;
        padding-bottom: 20px;
        backdrop-filter: blur(5px);
    }

    .pwa-modal.show {
        display: flex;
        animation: slideUp 0.4s ease-out;
    }

    .pwa-modal-content {
        background: #1a1f2e;
        border: 1px solid var(--accent-primary);
        border-radius: 20px 20px 0 0;
        padding: 2rem;
        width: 100%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 -5px 20px rgba(102, 252, 241, 0.2);
        position: relative;
    }

    @media(min-width: 768px) {
        .pwa-modal {
            align-items: center;
            padding-bottom: 0;
        }

        .pwa-modal-content {
            border-radius: 20px;
        }
    }

    .pwa-icon-wrapper {
        width: 80px;
        height: 80px;
        margin: -60px auto 20px;
        border-radius: 50%;
        padding: 5px;
        background: #1a1f2e;
        border: 2px solid var(--accent-primary);
    }

    .pwa-logo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .pwa-modal h3 {
        color: #fff;
        margin-bottom: 10px;
        font-family: 'Orbitron', sans-serif;
    }

    .pwa-modal p {
        color: #a0a0a0;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .pwa-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-text {
        background: none;
        border: none;
        color: #a0a0a0;
        cursor: pointer;
        font-size: 0.9rem;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }

        to {
            transform: translateY(0);
        }
    }
</style>

<script>
    // PWA Install Prompt Logic
    let deferredPrompt;
    const pwaModal = document.getElementById('pwa-install-modal');
    const installBtn = document.getElementById('pwa-install-btn');
    const dismissBtn = document.getElementById('pwa-dismiss');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;

        // Check if user already dismissed it recently (optional localStorage check)
        if (!localStorage.getItem('pwa_dismissed')) {
            // Show the modal
            pwaModal.classList.add('show');
        }
    });

    installBtn.addEventListener('click', (e) => {
        // Hide UI
        pwaModal.classList.remove('show');
        // Show the install prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            deferredPrompt = null;
        });
    });

    dismissBtn.addEventListener('click', () => {
        pwaModal.classList.remove('show');
        // Remind later?
        localStorage.setItem('pwa_dismissed', 'true');
    });

    // Handle installed state
    window.addEventListener('appinstalled', () => {
        pwaModal.classList.remove('show');
        deferredPrompt = null;
        console.log('PWA was installed');
    });
</script>

</body>

</html>