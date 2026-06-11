<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - MindFlow Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #A881C2; /* Solid Purple from User layout */
            --primary-light: #f3e8f5;
            --primary-hover: #8A64A4;
            --bg-color: #FAFAFB;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #f3f4f6;
            --border-dark: #e5e7eb;
            --sidebar-left-w: 280px;
        }

        * { font-family: 'Poppins', sans-serif; }

        /* --- Sidebar Kiri (matches layouts.app) --- */
        .sidebar-left {
            width: var(--sidebar-left-w);
            background-color: #FFFFFF;
            border-right: 1px solid var(--border-dark);
            padding: 40px 0 10px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 10;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-collapsed .sidebar-left {
            margin-left: calc(-1 * var(--sidebar-left-w));
        }

        /* Floating Sidebar Toggle Button */
        .floating-sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 99;
            width: 44px;
            height: 44px;
            background-color: #FFFFFF;
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(168, 129, 194, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .floating-sidebar-toggle.visible { display: flex; }

        .floating-sidebar-toggle svg {
            width: 22px;
            height: 22px;
            stroke: var(--primary);
            stroke-width: 2;
            fill: none;
        }

        .floating-sidebar-toggle:hover {
            transform: scale(1.05);
            background-color: var(--primary-light);
            border-color: var(--primary);
        }

        .sidebar-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            color: var(--text-muted);
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .sidebar-toggle-btn:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1);
        }

        .sidebar-toggle-btn:active { transform: scale(0.9); }

        .brand {
            display: flex;
            align-items: center;
            padding: 0 30px;
            margin-bottom: 50px;
            font-size: 24px;
            font-weight: 700;
            color: #1A1A1A;
        }

        .brand span.flow {
            color: var(--primary);
        }

        .menu-title {
            padding: 0 30px;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 16px 30px;
            color: #1A1A1A;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s, color 0.2s, border-left-color 0.2s;
            border-left: 4px solid transparent;
            transform-origin: left center;
        }

        .menu-item:hover {
            background-color: #F9F9F9;
            transform: scale(1.05) translateX(4px);
        }

        .menu-item.active {
            background-color: #F4EEFB;
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .menu-item svg {
            width: 24px;
            height: 24px;
            margin-right: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .menu-item.active svg {
            stroke: var(--primary);
        }

        .sidebar-spacer {
            flex: 1;
        }

        /* --- Sidebar Profile Section (matches layouts.app) --- */
        .sidebar-profile-section {
            position: relative;
            padding: 20px 24px;
            border-top: 1px solid var(--border-dark);
        }

        .sidebar-profile-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 10px 12px;
            border: none;
            background: transparent;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
        }

        .sidebar-profile-btn:hover {
            background-color: #F4EEFB;
        }

        .sidebar-profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            flex-shrink: 0;
        }

        .sidebar-profile-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-profile-name {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-profile-role {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        .sidebar-profile-chevron {
            width: 18px;
            height: 18px;
            stroke: var(--text-muted);
            stroke-width: 2;
            fill: none;
            transition: transform 0.25s ease;
            flex-shrink: 0;
        }

        .sidebar-profile-btn.open .sidebar-profile-chevron {
            transform: rotate(180deg);
        }

        /* Popup Menu */
        .sidebar-popup {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 20px;
            right: 20px;
            background: #FFFFFF;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border-dark);
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 100;
        }

        .sidebar-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .sidebar-popup-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: none;
            background: transparent;
            width: 100%;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-main);
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .sidebar-popup-item:hover {
            background-color: #F4EEFB;
            color: var(--primary);
        }

        .sidebar-popup-item svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        .sidebar-popup-item.logout-item:hover {
            background-color: #FEF2F2;
            color: #DC2626;
        }

        .sidebar-popup-divider {
            height: 1px;
            background: var(--border-dark);
            margin: 4px 8px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased text-gray-900">
    <!-- Floating Expand Sidebar Button -->
    <button type="button" id="sidebarExpandBtn" class="floating-sidebar-toggle" title="Expand Sidebar">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>
    <div class="flex h-screen overflow-hidden">

        {{-- ═══════════════ SIDEBAR ═══════════════ --}}
        <aside class="sidebar-left">
            <div class="brand" style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding-right: 20px;">
                <div style="display: flex; align-items: center;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" style="width: 36px; height: 36px; margin-right: 12px; object-fit: contain;">
                    <div>Mind<span class="flow">Flow</span></div>
                </div>
                <button type="button" id="sidebarCollapseBtn" class="sidebar-toggle-btn" title="Collapse Sidebar">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
            </div>

            <div class="menu-title">Menu</div>
            <ul class="menu-list">
                @include('admin.partials.sidebar-items')
            </ul>

            <div class="sidebar-spacer"></div>

            {{-- Profile Section --}}
            <div class="sidebar-profile-section" id="profileSection">
                <div class="sidebar-popup" id="profilePopup">
                    <a href="{{ route('admin.settings') }}" class="sidebar-popup-item" id="btn-admin-pengaturan">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        Pengaturan
                    </a>
                    <div class="sidebar-popup-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="sidebar-popup-item logout-item" id="btn-admin-logout">
                            <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Keluar
                        </button>
                    </form>
                </div>
                <button class="sidebar-profile-btn" id="profileBtn" type="button">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'Admin') }}&background=E8DEFA&color=6B3FA0&size=42&font-size=0.4&bold=true" alt="Profile" class="sidebar-profile-avatar">
                    <div class="sidebar-profile-info">
                        <div class="sidebar-profile-name">{{ Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'Admin' }}</div>
                        <div class="sidebar-profile-role">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</div>
                    </div>
                    <svg class="sidebar-profile-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
            </div>
        </aside>

        {{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Bar --}}
            <header class="h-[72px] bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Admin')</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Admin' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Admin') }}&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Admin Profile Popup & Sidebar Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ── Profile Popup ──────────────────────────────
            const profileBtn = document.getElementById('profileBtn');
            const profilePopup = document.getElementById('profilePopup');

            if (profileBtn && profilePopup) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profilePopup.classList.toggle('show');
                    profileBtn.classList.toggle('open');
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#profileSection')) {
                        profilePopup.classList.remove('show');
                        profileBtn.classList.remove('open');
                    }
                });
            }

            // ── Sidebar Collapse / Expand Toggle ───────────
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            const expandBtn   = document.getElementById('sidebarExpandBtn');
            const layout      = document.querySelector('.flex.h-screen');
            const STORAGE_KEY = 'mindflow_sidebar_collapsed';

            function setSidebarState(collapsed, animate) {
                if (!animate) {
                    const sidebar = document.querySelector('.sidebar-left');
                    if (sidebar) sidebar.style.transition = 'none';
                    requestAnimationFrame(function() {
                        if (sidebar) sidebar.style.transition = '';
                    });
                }
                if (collapsed) {
                    if (layout) layout.classList.add('sidebar-collapsed');
                    if (expandBtn) expandBtn.classList.add('visible');
                } else {
                    if (layout) layout.classList.remove('sidebar-collapsed');
                    if (expandBtn) expandBtn.classList.remove('visible');
                }
                localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
            }

            const storedCollapsed = localStorage.getItem(STORAGE_KEY) === '1';
            setSidebarState(storedCollapsed, false);

            if (collapseBtn) {
                collapseBtn.addEventListener('click', function() { setSidebarState(true, true); });
            }
            if (expandBtn) {
                expandBtn.addEventListener('click', function() { setSidebarState(false, true); });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
