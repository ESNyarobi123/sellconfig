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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body>
    <!-- Animated Background -->
    <div class="cyber-bg">
        <div class="cyber-grid"></div>
        <div class="cyber-glow"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">⚡</span>
                <span class="logo-text">SellConfig</span>
            </a>

            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span>
                    <span>Nyumbani</span>
                </a>

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
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <span class="logo-icon">⚡</span>
                    <span>SellConfig</span>
                </div>
                <p class="footer-text">Premium VPN Configs kwa bei nafuu</p>
                @php $whatsapp = \App\Models\Setting::get('whatsapp_number'); @endphp
                @if($whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" class="whatsapp-btn"
                        target="_blank">
                        <span>💬</span> WhatsApp Support
                    </a>
                @endif
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SellConfig. Haki zote zimehifadhiwa.</p>
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
    </script>
    @stack('scripts')
</body>

</html>