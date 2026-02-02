<!DOCTYPE html>
<html lang="sw">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - CYBER.NET SERVICE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Rajdhani:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="icon" href="{{ asset('cyberlogo.jpg') }}" type="image/jpeg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset('cyberlogo.jpg') }}" alt="Admin Logo"
                        style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-primary); margin-right: 8px;">
                    <span class="logo-text">Admin</span>
                </a>
                <button class="sidebar-close" onclick="toggleSidebar()">×</button>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="link-icon">📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.plans.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                    <span class="link-icon">📦</span>
                    <span>Plans</span>
                </a>

                <a href="{{ route('admin.configs.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.configs.*') ? 'active' : '' }}">
                    <span class="link-icon">🔐</span>
                    <span>Configs</span>
                </a>

                <a href="{{ route('admin.sales') }}"
                    class="sidebar-link {{ request()->routeIs('admin.sales') ? 'active' : '' }}">
                    <span class="link-icon">💰</span>
                    <span>Sales</span>
                </a>

                <a href="{{ route('admin.users') }}"
                    class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span class="link-icon">👥</span>
                    <span>Users</span>
                </a>

                <a href="{{ route('admin.notifications.create') }}"
                    class="sidebar-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                    <span class="link-icon">🔔</span>
                    <span>Push Notify</span>
                </a>

                <div class="sidebar-divider"></div>

                <a href="{{ route('admin.settings') }}"
                    class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <span class="link-icon">⚙️</span>
                    <span>Settings</span>
                </a>

                <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                    <span class="link-icon">🌐</span>
                    <span>View Site</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="sidebar-logout">
                    @csrf
                    <button type="submit" class="sidebar-link logout-link">
                        <span class="link-icon">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Bar -->
            <header class="admin-topbar">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="topbar-title">
                    @yield('header', 'Dashboard')
                </div>

                <div class="topbar-user">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-badge">Admin</span>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="admin-alert alert-success">
                    <span class="alert-icon">✅</span>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif

            @if(session('error'))
                <div class="admin-alert alert-error">
                    <span class="alert-icon">❌</span>
                    {{ session('error') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif

            <!-- Page Content -->
            <main class="admin-content">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Close sidebar on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                document.getElementById('sidebar').classList.remove('active');
            }
        });

        // Auto dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('.admin-alert').forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>

</html>