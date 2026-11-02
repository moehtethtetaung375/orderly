<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') | Orderly</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --orderly-primary: #7138e5;
            --orderly-primary-dark: #5926c4;
            --orderly-primary-light: #f1eaff;
            --orderly-bg: #f7f6fb;
            --orderly-text: #211b35;
            --orderly-muted: #858096;
            --orderly-border: #eeeaf5;
            --orderly-sidebar-width: 255px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--orderly-bg);
            color: var(--orderly-text);
            font-family: Arial, sans-serif;
        }

        a {
            text-decoration: none;
        }

        /* SIDEBAR */
        .orderly-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            width: var(--orderly-sidebar-width);
            padding: 25px 17px 18px;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid var(--orderly-border);
            transition: transform .25s ease;
        }

        .orderly-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px;
            margin-bottom: 38px;
            color: var(--orderly-primary);
        }

        .orderly-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 13px;
            background: var(--orderly-primary);
            color: #fff;
            font-size: 22px;
            box-shadow: 0 5px 14px rgba(113, 56, 229, .22);
        }

        .orderly-brand-name {
            display: block;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.6px;
        }

        .orderly-brand-caption {
            display: block;
            margin-top: 3px;
            color: var(--orderly-muted);
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .orderly-menu-label {
            margin: 0 12px 12px;
            color: #a19bb1;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .orderly-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .orderly-nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 13px;
            border-radius: 11px;
            color: #777187;
            font-size: 14px;
            font-weight: 600;
            transition: background .2s, color .2s;
        }

        .orderly-nav-link i {
            width: 21px;
            font-size: 18px;
            text-align: center;
        }

        .orderly-nav-link:hover {
            color: var(--orderly-primary);
            background: #f8f5ff;
        }

        .orderly-nav-link.active {
            color: var(--orderly-primary);
            background: var(--orderly-primary-light);
        }

        /* LOGOUT: KEEP AT THE BOTTOM OF SIDEBAR */
        .orderly-sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
        }

        .orderly-logout {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 11px 13px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #d34a55;
            font-size: 14px;
            font-weight: 600;
            text-align: left;
            transition: background .2s;
            cursor: pointer;
        }

        .orderly-logout:hover {
            background: #fff0f1;
        }

        /* MAIN APPLICATION */
        .orderly-main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: var(--orderly-sidebar-width);
        }

        /* TOP BAR */
        .orderly-topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            padding: 12px 32px;
            background: #fff;
            border-bottom: 1px solid var(--orderly-border);
        }

        .orderly-topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .orderly-topbar-title {
            margin: 0;
            font-size: 18px;
            font-weight: 750;
            letter-spacing: -.3px;
        }

        .orderly-mobile-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border: 1px solid var(--orderly-border);
            border-radius: 11px;
            background: #fff;
            color: var(--orderly-primary);
            font-size: 22px;
            cursor: pointer;
        }

        /* TOP-RIGHT USER AVATAR */
        .orderly-user-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 8px 5px 5px;
            border: 1px solid transparent;
            border-radius: 14px;
            background: #fff;
            color: var(--orderly-text);
            transition: background .2s, border-color .2s;
        }

        .orderly-user-toggle:hover,
        .orderly-user-toggle[aria-expanded="true"] {
            border-color: var(--orderly-border);
            background: #faf8ff;
        }

        .orderly-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 17px;
            background: linear-gradient(135deg, #8157eb, #5b35c4);
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(101, 88, 211, 0.17);
        }

        .orderly-topbar-user-info {
            min-width: 0;
            text-align: left;
        }

        .orderly-topbar-user-name {
            max-width: 160px;
            overflow: hidden;
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .orderly-topbar-user-caption {
            margin-top: 3px;
            color: var(--orderly-muted);
            font-size: 11px;
        }

        .orderly-user-chevron {
            margin-left: 3px;
            color: var(--orderly-muted);
            font-size: 12px;
        }

        .orderly-user-menu {
            width: 260px;
            padding: 8px;
            margin-top: 10px !important;
            border: 1px solid var(--orderly-border);
            border-radius: 15px;
            box-shadow: 0 12px 35px rgba(42, 26, 80, .12);
        }

        .orderly-dropdown-user-details {
            padding: 12px;
            margin-bottom: 6px;
            border-bottom: 1px solid var(--orderly-border);
        }

        .orderly-dropdown-name {
            overflow-wrap: anywhere;
            color: var(--orderly-text);
            font-size: 14px;
            font-weight: 750;
        }

        .orderly-dropdown-email {
            margin-top: 5px;
            overflow-wrap: anywhere;
            color: var(--orderly-muted);
            font-size: 12px;
        }

        .orderly-dropdown-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px 12px;
            border-radius: 9px;
            color: #625b73;
            font-size: 13px;
            font-weight: 600;
        }

        .orderly-dropdown-link i {
            width: 18px;
            font-size: 16px;
            text-align: center;
        }

        .orderly-dropdown-link:hover {
            background: #f6f2ff;
            color: var(--orderly-primary);
        }

        /* CONTENT */
        .orderly-content {
            flex: 1;
            width: 100%;
            max-width: 1600px;
            padding: 34px 32px 42px;
            margin: 0 auto;
        }

        .orderly-content-heading {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
        }

        .orderly-heading-text {
            min-width: 0;
        }

        .orderly-page-title {
            margin: 0;
            font-size: 25px;
            font-weight: 750;
            letter-spacing: -.5px;
        }

        .orderly-page-subtitle {
            margin-top: 7px;
            color: var(--orderly-muted);
            font-size: 13px;
        }

        .orderly-footer {
            padding: 17px 25px;
            border-top: 1px solid var(--orderly-border);
            color: var(--orderly-muted);
            font-size: 12px;
            text-align: center;
        }

        /* SHARED COMPONENTS */
        .btn-purple {
            border-color: var(--orderly-primary);
            border-radius: 10px;
            background: var(--orderly-primary);
            color: #fff;
            font-weight: 600;
        }

        .btn-purple:hover,
        .btn-purple:focus {
            border-color: var(--orderly-primary-dark);
            background: var(--orderly-primary-dark);
            color: #fff;
        }

        .content-card {
            border: 1px solid var(--orderly-border);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(66, 35, 120, .04);
        }

        .orderly-sidebar-overlay {
            display: none;
        }

        /* LOGIN / REGISTER */
        .orderly-guest-main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 28px 18px;
        }

        .orderly-guest-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--orderly-primary);
            font-size: 22px;
            font-weight: 800;
        }

        .orderly-guest-content {
            width: 100%;
            max-width: 1200px;
            margin: auto;
        }

        /* RESPONSIVE */
        @media (max-width: 991.98px) {
            .orderly-sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .orderly-sidebar.is-open {
                transform: translateX(0);
                box-shadow: 10px 0 40px rgba(30, 20, 60, .12);
            }

            .orderly-sidebar-overlay.is-visible {
                position: fixed;
                inset: 0;
                z-index: 1030;
                display: block;
                background: rgba(25, 18, 45, .4);
            }

            .orderly-main {
                margin-left: 0;
            }

            .orderly-mobile-toggle {
                display: inline-flex;
            }

            .orderly-topbar {
                min-height: 68px;
                padding: 10px 20px;
            }

            .orderly-content {
                padding: 24px 20px 35px;
            }

            .orderly-footer {
                padding: 16px 18px;
            }
        }

        @media (max-width: 575.98px) {
            .orderly-topbar {
                padding: 10px 13px;
            }

            .orderly-topbar-title {
                font-size: 16px;
            }

            .orderly-topbar-user-info,
            .orderly-user-chevron {
                display: none;
            }

            .orderly-user-toggle {
                padding: 3px;
            }

            .orderly-avatar {
                width: 39px;
                height: 39px;
            }

            .orderly-user-menu {
                width: 245px;
            }

            .orderly-content {
                padding: 20px 13px 30px;
            }

            .orderly-content-heading {
                gap: 11px;
                margin-bottom: 22px;
            }

            .orderly-page-title {
                font-size: 21px;
            }

            .orderly-page-subtitle {
                font-size: 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

@auth

    {{-- Mobile Sidebar Overlay --}}
    <div class="orderly-sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Left Sidebar --}}
    <aside class="orderly-sidebar" id="appSidebar">

        {{-- Brand --}}
        <a href="{{ route('dashboard') }}" class="orderly-brand">
            <span class="orderly-brand-icon">
                <i class="bi bi-layers-half"></i>
            </span>

            <span>
                <span class="orderly-brand-name">Orderly</span>
                <span class="orderly-brand-caption">
                    ORDER MANAGEMENT SYSTEM
                </span>
            </span>
        </a>

        <div class="orderly-menu-label">Main Menu</div>

        <ul class="orderly-nav">
            <li>
                <a
                    href="{{ route('dashboard') }}"
                    class="orderly-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a
                    href="{{ route('items.index') }}"
                    class="orderly-nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}"
                >
                    <i class="bi bi-box-seam"></i>
                    <span>Items</span>
                </a>
            </li>

            <li>
                <a
                    href="{{ route('orders.index') }}"
                    class="orderly-nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                >
                    <i class="bi bi-receipt"></i>
                    <span>Orders</span>
                </a>
            </li>
        </ul>

        {{-- Logout remains at the original bottom-left position --}}
        <div class="orderly-sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="orderly-logout">
                    <i class="bi bi-box-arrow-left fs-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- Main Application --}}
    <div class="orderly-main">

        {{-- Top Bar --}}
        <header class="orderly-topbar">

            <div class="orderly-topbar-left">
                <button
                    type="button"
                    class="orderly-mobile-toggle"
                    id="sidebarToggle"
                    aria-label="Toggle navigation"
                    aria-controls="appSidebar"
                    aria-expanded="false"
                >
                    <i class="bi bi-list"></i>
                </button>
            </div>
            
            {{-- Top Right: Notification and User Profile --}}
            <div class="d-flex align-items-center gap-3">

                {{-- Notification Bell --}}
                <div class="dropdown">

                    <button
                        type="button"
                        class="btn position-relative border-0 rounded-circle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="Notifications"
                        style="width: 42px; height: 42px; background: #f7f5fc; color: #7138e5;"
                    >
                        <i class="bi bi-bell fs-5"></i>

                        {{-- Unread Count --}}
                        @php
                            $unreadCount = Auth::user()->unreadNotifications()->count();
                        @endphp

                        @if ($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    {{-- Notification Dropdown --}}
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2 mt-2"
                        style="width: 330px; max-height: 420px; overflow-y: auto;">

                        <li class="d-flex justify-content-between align-items-center px-2 py-2">
                            <strong style="color: #211b35;">Notifications</strong>

                            <a href="{{ route('notifications.index') }}"
                            class="small text-decoration-none"
                            style="color: #7138e5;">
                                View All
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        @forelse (Auth::user()->notifications()->latest()->take(5)->get() as $notification)

                            <li>
                                <form
                                    action="{{ route('notifications.read', $notification->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="dropdown-item rounded-3 text-wrap py-2
                                        {{ is_null($notification->read_at) ? 'bg-light' : '' }}"
                                    >
                                        <div class="fw-semibold small mb-1">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </div>

                                        <div class="text-muted small">
                                            {{ $notification->data['message'] ?? '' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </button>
                                </form>
                            </li>

                        @empty

                            <li class="text-center text-muted small py-4">
                                <i class="bi bi-bell-slash fs-4 d-block mb-2"></i>
                                No notifications yet.
                            </li>

                        @endforelse

                    </ul>
                </div>

                {{-- User Profile --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="orderly-profile-link"
                    aria-label="Edit My Profile"
                >
                    <span class="orderly-avatar">
                        {{ strtoupper(substr(trim(Auth::user()->name ?? 'U'), 0, 1)) }}
                    </span>
                </a>

            </div>

        </header>

        {{-- Page Content --}}
        <main class="orderly-content">

            @if (session('success'))
                <div
                    class="alert alert-success alert-dismissible fade show rounded-3 auto-dismiss-alert"
                    role="alert"
                >
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="alert alert-danger alert-dismissible fade show rounded-3 auto-dismiss-alert"
                    role="alert"
                >
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
            @endif

            
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.auto-dismiss').forEach(function (alert) {
                        setTimeout(function () {
                            bootstrap.Alert.getOrCreateInstance(alert).close();
                        }, 1000);
                    });
                });
            </script>


                        @yield('content')

                    </main>

                    <footer class="orderly-footer">
                        &copy; {{ date('Y') }} Orderly. Order Management System.
                    </footer>

                </div>

            @else

    {{-- Guest Layout: Login and Register --}}
    <main class="orderly-guest-main">

        <div class="container">
            <a href="{{ route('login') }}" class="orderly-guest-brand">
                <span class="orderly-brand-icon">
                    <i class="bi bi-layers-half"></i>
                </span>
                Orderly
            </a>
        </div>

        <div class="orderly-guest-content">

            @if (session('success'))
                <div
                    class="alert alert-success alert-dismissible fade show rounded-3 auto-dismiss-alert"
                    role="alert"
                >
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="alert alert-danger alert-dismissible fade show rounded-3 auto-dismiss-alert"
                    role="alert"
                >
                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-3" role="alert">
                    <strong>Please check the following errors:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </div>

        <footer class="text-center text-muted small mt-4">
            &copy; {{ date('Y') }} Orderly. All rights reserved.
        </footer>

    </main>

@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Mobile Sidebar JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('appSidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (!sidebar || !toggle || !overlay) {
        return;
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    toggle.addEventListener('click', function () {
        if (sidebar.classList.contains('is-open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    overlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });
});
</script>

{{-- Auto-dismiss Success and Error Messages --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.auto-dismiss-alert').forEach(function (message) {
        setTimeout(function () {
            message.style.transition = 'opacity 0.5s ease';
            message.style.opacity = '0';

            setTimeout(function () {
                message.remove();
            }, 500);
        }, 3000);
    });
});
</script>

@stack('scripts')

</body>
</html>
