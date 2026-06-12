<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindFlow - Forum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #A881C2; /* Solid Purple from Image 2 */
            --primary-light: #f3e8f5;
            --primary-hover: #8A64A4;
            --bg-color: #FAFAFB;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #f3f4f6;
            --border-dark: #e5e7eb;
            --sidebar-left-w: 280px;
            --sidebar-right-w: 300px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .layout {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* --- Left Sidebar --- */
        .sidebar-left {
            width: var(--sidebar-left-w);
            background-color: #FFFFFF;
            border-right: 1px solid var(--border-dark);
            padding: 40px 0 10px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 10;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .sidebar-collapsed .sidebar-left {
            margin-left: calc(-1 * var(--sidebar-left-w)) !important;
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
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(168, 129, 194, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .floating-sidebar-toggle svg {
            width: 22px;
            height: 22px;
            stroke: #A881C2;
            stroke-width: 2;
            fill: none;
        }

        .floating-sidebar-toggle:hover {
            transform: scale(1.05);
            background-color: #F4EEFB;
            border-color: #A881C2;
        }

        .floating-sidebar-toggle:active {
            transform: scale(0.95);
        }

        .sidebar-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-toggle-btn:hover {
            background-color: #F4EEFB;
            color: #A881C2 !important;
            transform: scale(1.1);
        }
        
        .sidebar-toggle-btn:active {
            transform: scale(0.9);
        }

        .brand {
            display: flex;
            align-items: center;
            padding: 0 30px;
            margin-bottom: 50px;
            font-size: 24px;
            font-weight: 700;
            color: #1A1A1A;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: #1A2542;
            border-radius: 50%;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFF;
            position: relative;
            overflow: hidden;
        }

        .brand-icon::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #8FA1D0;
            border-radius: 50%;
            top: 10px;
            left: 10px;
        }

        .brand span.flow {
            color: #A881C2;
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
            color: #A881C2;
            border-left-color: #A881C2;
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
            stroke: #A881C2;
        }

        /* --- SIDEBAR PROFILE SECTION --- */
        .sidebar-spacer {
            flex: 1;
        }

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
            border: 2px solid #A881C2;
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
            color: #A881C2;
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

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 50px 60px;
            overflow-y: auto;
            border-right: 1px solid var(--border-dark);
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            background-color: #EAEAEA;
        }

        .welcome-text h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .welcome-text p {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 400;
        }

        /* --- Right Sidebar --- */
        .sidebar-right {
            width: var(--sidebar-right-w);
            padding: 40px 24px;
            flex-shrink: 0;
            overflow-y: auto;
            background-color: var(--bg-color);
        }

        .right-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .right-header h3 {
            font-size: 0.95rem;
            font-weight: 700;
        }
        .right-header a {
            color: var(--primary);
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 500;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 40px;
        }
        .empty-illustration {
            width: 180px;
            height: 140px;
            background-color: #f3f4f6;
            margin-bottom: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }
        .empty-state p {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .alert {
            padding: 12px 24px;
            background-color: #dcfce7;
            color: #166534;
            font-size: 0.9rem;
            font-weight: 500;
            border-bottom: 1px solid var(--border-dark);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--text-muted);
            border: 2px solid var(--border-dark);
        }

        .btn-outline:hover {
            background-color: var(--bg-color);
            color: var(--text-main);
            border-color: var(--text-muted);
        }
    </style>
    @stack('styles')
</head><body>
    <!-- Floating Expand Sidebar Button -->
    <button type="button" id="sidebarExpandBtn" class="floating-sidebar-toggle" style="display: none;" title="Expand Sidebar">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>
    <div class="layout">
        <!-- Sidebar Kiri -->
        <aside class="sidebar-left">
            <div class="brand" style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding-right: 20px;">
                <div style="display: flex; align-items: center;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" style="width: 36px; height: 36px; margin-right: 12px; object-fit: contain;">
                    <div>Mind<span class="flow">Flow</span></div>
                </div>
                <button type="button" id="sidebarCollapseBtn" class="sidebar-toggle-btn" title="Collapse Sidebar">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
            </div>
            
            <div class="menu-title">Menu</div>
            <ul class="menu-list">
                @if(Auth::check() && Auth::user()->role === 'admin')
                @include('admin.partials.sidebar-items')
                @elseif(Auth::check() && Auth::user()->role === 'konselor')
                {{-- Konselor Menu --}}
                <li>
                    <a href="{{ route('konselor.dashboard') }}" class="menu-item {{ request()->is('konselor*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Dashboard Konselor
                    </a>
                </li>
                <li>
                    <a href="{{ route('forum.index') }}" class="menu-item {{ request()->is('forum*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Forum
                    </a>
                </li>
                <li>
                    <a href="{{ route('artikel.index') }}" class="menu-item {{ request()->is('artikel*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                        Artikel
                    </a>
                </li>
                @else
                {{-- Regular User Menu --}}
                <li>
                    <a href="{{ route('homepage') }}" class="menu-item {{ request()->is('home') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Homepage
                    </a>
                </li>
                <li>
                    <a href="{{ route('konseling.index') }}" class="menu-item {{ request()->is('konseling*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Konsultasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('mood-tracker.index') }}" class="menu-item {{ request()->is('mood-tracker*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                        Mood Tracker
                    </a>
                </li>
                <li>
                    <a href="{{ route('forum.index') }}" class="menu-item {{ request()->is('forum*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Forum
                    </a>
                </li>
                <li>
                    <a href="{{ route('journals.index') }}" class="menu-item {{ request()->is('journals*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        Jurnal
                    </a>
                </li>
                <li>
                    <a href="{{ route('artikel.index') }}" class="menu-item {{ request()->is('artikel*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                        Artikel
                    </a>
                </li>
                @endif
            </ul>

            <!-- Spacer to push profile to bottom -->
            <div class="sidebar-spacer"></div>

            <!-- Profile Section -->
            <div class="sidebar-profile-section" id="profileSection">
                <!-- Popup Menu -->
                <div class="sidebar-popup" id="profilePopup">
                    @if(Auth::check() && Auth::user()->role === 'admin')
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
                    @else
                        <a href="{{ route('settings.edit') }}" class="sidebar-popup-item" id="btn-pengaturan">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            Pengaturan
                        </a>
                        <div class="sidebar-popup-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="sidebar-popup-item logout-item" id="btn-logout">
                                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                Keluar
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Profile Button -->
                <button class="sidebar-profile-btn" id="profileBtn" type="button">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'User') }}&background=E8DEFA&color=6B3FA0&size=42&font-size=0.4&bold=true" alt="Profile" class="sidebar-profile-avatar">
                    <div class="sidebar-profile-info">
                        <div class="sidebar-profile-name">{{ Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'User' }}</div>
                        <div class="sidebar-profile-role">{{ ucfirst(Auth::user()->role ?? 'Mahasiswa') }}</div>
                    </div>
                    <svg class="sidebar-profile-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
            </div>
        </aside>

        <!-- Main Content (Tengah) -->
        <main class="main-content">
            <div class="header">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_samaran ?? 'User') }}&background=E2E8F0&color=475569&size=65" alt="Profile" class="avatar">
                <div class="welcome-text">
                    <h1>Welcome, {{ Auth::user()->nama_asli ?? 'User' }}!</h1>
                    <p>How's your day?</p>
                </div>
            </div>

            @if(session('success') && !request()->is('konseling*'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-sm shadow-emerald-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="text-emerald-400 hover:text-emerald-600 transition-colors" onclick="this.parentElement.style.display='none'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="auto-dismiss-notification bg-blue-50 border border-blue-100 text-blue-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-sm shadow-blue-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M12 19a7 7 0 110-14 7 7 0 010 14z"></path></svg>
                        </div>
                        <span class="font-bold text-sm">{{ session('info') }}</span>
                    </div>
                    <button type="button" class="text-blue-400 hover:text-blue-600 transition-colors" onclick="this.parentElement.style.display='none'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="auto-dismiss-notification bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white shadow-sm shadow-red-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <span class="font-bold text-sm">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="text-red-400 hover:text-red-600 transition-colors" onclick="this.parentElement.style.display='none'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                @foreach(Auth::user()->unreadNotifications as $notification)
                    <div class="bg-amber-50 border border-amber-100 text-amber-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white shadow-sm shadow-amber-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M12 19a7 7 0 110-14 7 7 0 010 14z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-sm">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</div>
                                <div class="text-xs">{{ $notification->data['message'] ?? '' }}</div>
                            </div>
                        </div>
                        <button type="button" class="text-amber-400 hover:text-amber-600 transition-colors" onclick="this.parentElement.style.display='none'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    @php $notification->markAsRead(); @endphp
                @endforeach
            @endif

            @if(session('mute_error'))
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[100] flex items-center justify-center animate-[fadeIn_0.2s_ease-out]" id="muteModal">
                    <div class="bg-white rounded-[24px] w-full max-w-sm shadow-xl p-8 text-center transform scale-100 mx-4">
                        <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-5">
                            <span class="text-4xl">🤫</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Akses Dibatasi</h3>
                        <p class="text-[15px] text-gray-600 mb-2 leading-relaxed font-medium">Anda dalam masa mute selama:</p>
                        <div class="text-2xl font-black text-[#A881C2] mb-6 tracking-wider" id="muteCountdown">00:00:00</div>
                        <p class="text-[14px] text-gray-500 mb-8 italic">Berkatalah dengan baik 😊</p>
                        <button onclick="document.getElementById('muteModal').remove()" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-sm shadow-purple-500/30">
                            Mengerti
                        </button>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const targetDate = new Date("{{ session('mute_until') }}").getTime();
                        const countdownEl = document.getElementById('muteCountdown');
                        
                        function updateCountdown() {
                            const now = new Date().getTime();
                            const distance = targetDate - now;
                            
                            if (distance <= 0) {
                                countdownEl.innerHTML = "Waktu habis!";
                                return;
                            }
                            
                            const hours = Math.floor(distance / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            
                            countdownEl.innerHTML = 
                                String(hours).padStart(2, '0') + ":" + 
                                String(minutes).padStart(2, '0') + ":" + 
                                String(seconds).padStart(2, '0');
                        }
                        
                        updateCountdown();
                        setInterval(updateCountdown, 1000);
                    });
                </script>
            @endif

            @if(session('expired_cancelled_sessions'))
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[100] flex items-center justify-center animate-[fadeIn_0.2s_ease-out]" id="expiredCancellationModal">
                    <div class="bg-white rounded-[24px] w-full max-w-md shadow-xl p-8 text-center transform scale-100 mx-4 border border-red-100">
                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                            <span class="text-4xl">⏰</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Pembatalan Otomatis</h3>
                        <p class="text-[14px] text-gray-600 mb-4 leading-relaxed font-medium">
                            Sesi konseling Anda telah dibatalkan secara otomatis oleh sistem karena tidak ada respons dari konselor hingga waktu yang dijadwalkan:
                        </p>
                        
                        <div class="bg-red-50/50 border border-red-100 rounded-2xl p-4 mb-6 text-left max-h-48 overflow-y-auto">
                            <p class="text-xs font-bold text-red-800 uppercase tracking-wider mb-2">Detail Sesi:</p>
                            <ul class="space-y-3">
                                @foreach(session('expired_cancelled_sessions') as $detail)
                                    <li class="flex flex-col gap-0.5 border-b border-red-100 pb-2 last:border-0 last:pb-0">
                                        <span class="text-[13px] font-bold text-gray-800">{{ $detail['konselor'] }}</span>
                                        <span class="text-[11px] font-medium text-gray-500">{{ $detail['jadwal'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <button onclick="clearExpiredNotification()" id="btn-mengerti-pembatalan" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-sm shadow-purple-500/30">
                            Mengerti
                        </button>
                    </div>
                </div>
                <script>
                    function clearExpiredNotification() {
                        fetch("{{ route('booking.clear-expired-notification') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        }).then(response => {
                            document.getElementById('expiredCancellationModal').remove();
                        }).catch(err => {
                            document.getElementById('expiredCancellationModal').remove();
                        });
                    }
                </script>
            @endif

            @yield('content')
        </main>

        <!-- Sidebar Kanan -->
        @unless(request()->routeIs('artikel.*'))
        <aside class="sidebar-right">
            <div class="right-header">
                <h3 class="text-gray-900 font-bold">Jadwal Konsultasi</h3>
                <a href="{{ route('konseling.history') }}" class="text-[#A881C2] hover:text-[#8A64A4] font-bold text-xs transition-colors">Riwayat Sesi</a>
            </div>
            
            @if(isset($jadwalKonsultasi) && $jadwalKonsultasi->whereNotIn('status', ['cancelled', 'system_cancelled', 'completed'])->isEmpty())
                <div class="empty-state">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-inner">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-300"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-[13px] font-medium text-gray-400">Belum ada jadwal<br>konsultasi aktif</p>
                </div>
            @elseif(isset($jadwalKonsultasi))
                <div class="flex flex-col gap-5">
                    @foreach($jadwalKonsultasi->whereNotIn('status', ['cancelled', 'system_cancelled', 'completed']) as $jadwal)
                        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-[0_4px_12px_-2px_rgba(0,0,0,0.03)] hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-[14px] leading-tight mb-1 group-hover:text-[#A881C2] transition-colors">{{ $jadwal->profilKonselor ? $jadwal->profilKonselor->nama : 'Konselor' }}</h4>
                                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($jadwal->jadwal)->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                                <div class="p-1.5 rounded-lg bg-purple-50 text-[#A881C2]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>
                                                       
                            <div class="mb-5 flex flex-wrap gap-2">
                                @php
                                    $statusColor = match($jadwal->status) {
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'rescheduled' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'confirmed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'completed' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-gray-50 text-gray-600 border-gray-100'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 {{ $statusColor }} border rounded-lg text-[10px] font-black uppercase tracking-widest" title="Status Sesi">
                                    {{ $jadwal->status }}
                                </span>

                                @if($jadwal->payment_status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[10px] font-black uppercase tracking-widest" title="Status Pembayaran">
                                        Lunas
                                    </span>
                                @elseif($jadwal->payment_status === 'waiting_verification')
                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-lg text-[10px] font-black uppercase tracking-widest" title="Status Pembayaran">
                                        Verifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 border border-red-100 rounded-lg text-[10px] font-black uppercase tracking-widest" title="Status Pembayaran">
                                        Belum Bayar
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-col gap-2">
                                @if($jadwal->payment_status !== 'paid')
                                    <a href="{{ route('booking.checkout', $jadwal->sesi_konseling_id) }}" class="w-full text-center bg-[#A881C2] hover:bg-[#8A64A4] text-white py-3 rounded-xl text-[12px] font-bold transition-all duration-300 shadow-sm flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        Bayar Sekarang
                                    </a>
                                @endif

                                @if(in_array($jadwal->status, ['confirmed', 'rescheduled']))
                                    <a href="{{ route('konseling.room', $jadwal->sesi_konseling_id) }}" class="w-full text-center bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl text-[12px] font-bold transition-all duration-300 shadow-sm shadow-emerald-200 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Masuk Ruangan
                                    </a>
                                @endif
                                <div class="flex gap-2">
                                    <a href="{{ route('booking.edit', $jadwal->sesi_konseling_id) }}" class="{{ in_array($jadwal->status, ['confirmed', 'rescheduled']) ? 'w-full' : 'flex-1' }} text-center bg-gray-50 hover:bg-purple-50 hover:text-[#A881C2] text-gray-500 py-2.5 rounded-xl text-[11px] font-bold transition-all duration-300 border border-transparent hover:border-purple-100">
                                        Ubah
                                    </a>
                                    @if(!in_array($jadwal->status, ['confirmed', 'rescheduled']))
                                    <form action="{{ route('booking.cancel', $jadwal->sesi_konseling_id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan sesi ini?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gray-50 hover:bg-red-50 hover:text-red-500 text-gray-500 py-2.5 rounded-xl text-[11px] font-bold transition-all duration-300 border border-transparent hover:border-red-100">
                                            Batal
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-inner">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-300"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-[13px] font-medium text-gray-400">Belum ada jadwal<br>konsultasi aktif</p>
                </div>
            @endif
        </aside>
        @endunless
    </div>

    <!-- Profile Popup Toggle Script -->
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

            // ── Auto-dismiss Notifications ─────────────────
            const autoDismissNotifications = document.querySelectorAll('.auto-dismiss-notification');
            autoDismissNotifications.forEach(function(notification) {
                setTimeout(function() {
                    notification.style.transition = 'opacity 0.3s ease';
                    notification.style.opacity = '0';
                    setTimeout(function() { notification.remove(); }, 300);
                }, 4500);
            });

            // ── Sidebar Collapse / Expand Toggle ───────────
            const layout         = document.querySelector('.layout');
            const collapseBtn    = document.getElementById('sidebarCollapseBtn');
            const expandBtn      = document.getElementById('sidebarExpandBtn');
            const STORAGE_KEY    = 'mindflow_sidebar_collapsed';

            function setSidebarState(collapsed, animate) {
                if (!animate) {
                    // Briefly disable transitions to apply state instantly on page load
                    const sidebar = document.querySelector('.sidebar-left');
                    if (sidebar) sidebar.style.transition = 'none';
                    requestAnimationFrame(function() {
                        if (sidebar) sidebar.style.transition = '';
                    });
                }

                if (collapsed) {
                    layout.classList.add('sidebar-collapsed');
                    if (expandBtn) expandBtn.style.display = 'flex';
                } else {
                    layout.classList.remove('sidebar-collapsed');
                    if (expandBtn) expandBtn.style.display = 'none';
                }

                localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
            }

            // Restore state from localStorage on load (no animation)
            const storedCollapsed = localStorage.getItem(STORAGE_KEY) === '1';
            setSidebarState(storedCollapsed, false);

            if (collapseBtn) {
                collapseBtn.addEventListener('click', function() {
                    setSidebarState(true, true);
                });
            }

            if (expandBtn) {
                expandBtn.addEventListener('click', function() {
                    setSidebarState(false, true);
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
