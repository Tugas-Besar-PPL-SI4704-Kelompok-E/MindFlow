<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MindFlow Dashboard')</title>
    <style>
        /* Import Font Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        :root {
            --bg-body: #FAFAFB;
            --bg-surface: #FFFFFF;
            --text-dark: #1A1A1A;
            --text-muted: #8E8E93;
            --primary-purple: #9B76D6;
            --active-bg: #F4EEFB;
            --border-color: #EAEAEA;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 280px;
            background-color: var(--bg-surface);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 40px 0 10px 0;
            z-index: 10;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body.sidebar-collapsed .sidebar {
            margin-left: -280px;
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
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(155, 118, 214, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .floating-sidebar-toggle.visible { display: flex; }

        .floating-sidebar-toggle svg {
            width: 22px;
            height: 22px;
            stroke: #9B76D6;
            stroke-width: 2;
            fill: none;
        }

        .floating-sidebar-toggle:hover {
            transform: scale(1.05);
            background-color: #F4EEFB;
            border-color: #9B76D6;
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

        .sidebar-toggle-btn:hover {
            background-color: #F4EEFB;
            color: var(--primary-purple);
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
            color: var(--text-dark);
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
            color: var(--primary-purple);
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
            color: var(--text-dark);
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
            background-color: var(--active-bg);
            color: var(--primary-purple);
            border-left-color: var(--primary-purple);
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
            stroke: var(--primary-purple);
        }

        /* --- SIDEBAR PROFILE SECTION --- */
        .sidebar-spacer {
            flex: 1;
        }

        .sidebar-profile-section {
            position: relative;
            padding: 20px 24px;
            border-top: 1px solid var(--border-color);
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
            background-color: var(--active-bg);
        }

        .sidebar-profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-purple);
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
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-profile-role {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: var(--text-muted);
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
            background: var(--bg-surface);
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border-color);
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
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .sidebar-popup-item:hover {
            background-color: #F4EEFB;
            color: var(--primary-purple);
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
            background: var(--border-color);
            margin: 4px 8px;
        }

        /* ── Premium UI Designer 2026 Additions ── */
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(168, 129, 194, 0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(168, 129, 194, 0.6); }
        
        /* Input Focus State */
        input:focus, textarea:focus, select:focus {
            background-color: #ffffff !important;
            border-color: rgba(168, 129, 194, 0.5) !important;
            box-shadow: 0 0 0 4px rgba(168, 129, 194, 0.15) !important;
            outline: none !important;
        }

        /* Button Bouncy Micro-Interaction */
        button, a.btn, a[class*="bg-"] {
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, color 0.2s ease !important;
        }
        button:active:not(:disabled), a.btn:active, a[class*="bg-"]:active {
            transform: scale(0.97) !important;
        }

        /* Ambient Blobs */
        .ambient-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            z-index: -1;
            pointer-events: none;
            animation: pulse-blob 8s infinite alternate ease-in-out;
        }
        .ambient-blob-1 { top: -10%; left: -5%; width: 40vw; height: 40vw; background: #A881C2; }
        .ambient-blob-2 { bottom: -15%; right: -5%; width: 50vw; height: 50vw; background: #8A64A4; animation-delay: -4s; }
        @keyframes pulse-blob {
            0% { transform: scale(1) translate(0, 0); opacity: 0.15; }
            100% { transform: scale(1.1) translate(10px, -10px); opacity: 0.25; }
        }


        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            padding: 50px 60px;
            overflow-y: auto;
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

        @yield('styles')
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative">
    <div class="ambient-blob ambient-blob-1"></div>
    <div class="ambient-blob ambient-blob-2"></div>
    <!-- Floating Expand Sidebar Button -->
    <button type="button" id="sidebarExpandBtn" class="floating-sidebar-toggle" title="Expand Sidebar">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>

    @if(!isset($hideSidebar) || !$hideSidebar)
    <!-- SIDEBAR -->
    <aside class="sidebar">
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
                <a href="{{ route('konselor.dashboard') }}" class="menu-item {{ request()->routeIs('konselor.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('konselor.jadwal') }}" class="menu-item {{ request()->routeIs('konselor.jadwal') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Jadwal Konseling
                </a>
            </li>
            <li>
                <a href="{{ route('konselor.counselor-schedules.index') }}" class="menu-item {{ request()->routeIs('konselor.counselor-schedules.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ketersediaan Waktu
                </a>
            </li>
            <li>
                <a href="{{ route('konselor.pasien') }}" class="menu-item {{ request()->routeIs('konselor.pasien') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Daftar Pasien
                </a>
            </li>
            <li>
                <a href="{{ route('konselor.dompet') }}" class="menu-item {{ request()->routeIs('konselor.dompet') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Dompet & Pencairan
                </a>
            </li>
            <li>
                <a href="{{ route('forum.index') }}" class="menu-item {{ request()->routeIs('forum.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Forum MindFlow
                </a>
            </li>
            <li>
                <a href="{{ route('artikel.index') }}" class="menu-item {{ request()->routeIs('artikel.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"/></svg>
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
                <a href="{{ route('konseling.index') }}" class="menu-item {{ request()->is('konseling*') && !request()->is('konseling/history') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Konsultasi
                </a>
            </li>
            <li>
                <a href="{{ route('konseling.history') }}" class="menu-item {{ request()->is('konseling/history*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Riwayat Sesi
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
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.artikel.index') }}" class="menu-item {{ request()->is('admin/artikel*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                        Kelola Artikel
                    </a>
                @else
                    <a href="{{ route('artikel.index') }}" class="menu-item {{ request()->is('artikel*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                        Artikel
                    </a>
                @endif
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
                @elseif(Auth::check() && Auth::user()->role === 'konselor')
                    <a href="{{ route('konselor.settings') }}" class="sidebar-popup-item" id="btn-pengaturan">
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
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->role === 'konselor' ? Auth::user()->nama_asli : (Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'User')) }}&background=E8DEFA&color=6B3FA0&size=42&font-size=0.4&bold=true" alt="Profile" class="sidebar-profile-avatar">
                <div class="sidebar-profile-info">
                    <div class="sidebar-profile-name">{{ Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'User' }}</div>
                    <div class="sidebar-profile-role">{{ ucfirst(Auth::user()->role ?? 'Mahasiswa') }}</div>
                </div>
                <svg class="sidebar-profile-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
        </div>
    </aside>
    @endif

    <!-- MAIN CONTENT -->
    <main class="main-content">
        @if(!request()->is('home'))
        @if(Auth::check())
        <div class="header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->role === 'konselor' ? Auth::user()->nama_asli : (Auth::user()->nama_samaran ?? Auth::user()->nama_asli ?? 'User')) }}&background=E2E8F0&color=475569&size=65" alt="Profile" class="avatar">
            <div class="welcome-text">
                <h1 class="premium-text-gradient">Welcome, {{ Auth::user()->nama_asli ?? 'User' }}!</h1>
                <p>How's your day?</p>
            </div>
        </div>
        @endif
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

                    <button onclick="clearExpiredNotification()" id="btn-mengerti-pembatalan" class="w-full bg-[#9B76D6] hover:bg-[#8A64A4] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-sm shadow-purple-500/30">
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

        @if(session('refund_sessions'))
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[100] flex items-center justify-center animate-[fadeIn_0.2s_ease-out]" id="refundNotificationModal">
                <div class="bg-white rounded-[24px] w-full max-w-md shadow-xl p-8 text-center transform scale-100 mx-4 border border-purple-100">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                        <span class="text-4xl">💸</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pengembalian Dana (Refund)</h3>
                    <p class="text-[14px] text-gray-600 mb-4 leading-relaxed font-medium">
                        Sesi konseling Anda telah dibatalkan, dan pembayaran Anda akan dikembalikan (Refunded). Silakan hubungi admin kami untuk detail lebih lanjut.
                    </p>
                    
                    <div class="bg-purple-50/50 border border-purple-100 rounded-2xl p-4 mb-6 text-left max-h-48 overflow-y-auto">
                        <p class="text-xs font-bold text-purple-800 uppercase tracking-wider mb-2">Detail Sesi:</p>
                        <ul class="space-y-3">
                            @foreach(session('refund_sessions') as $detail)
                                <li class="flex flex-col gap-0.5 border-b border-purple-100 pb-2 last:border-0 last:pb-0">
                                    <span class="text-[13px] font-bold text-gray-800">{{ $detail['konselor'] }}</span>
                                    <span class="text-[11px] font-medium text-gray-500">{{ $detail['jadwal'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="https://wa.me/628123456789" target="_blank" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-sm shadow-emerald-500/30 flex items-center justify-center gap-2 text-sm text-center">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.498 1.45 5.441 1.451 5.58 0 10.121-4.544 10.125-10.13.002-2.707-1.05-5.251-2.962-7.163C17.34 1.4 14.793.35 12.008.35c-5.584 0-10.126 4.544-10.13 10.13-.001 1.905.498 3.766 1.448 5.372L2.302 21.72l5.975-1.566zM12.008 2.05c-4.636 0-8.411 3.774-8.415 8.413-.001 1.63.468 3.224 1.358 4.606l.325.508-.898 3.279 3.356-.88.498.295c1.332.79 2.85 1.206 4.417 1.207 4.64 0 8.415-3.774 8.418-8.414.002-2.25-.873-4.364-2.464-5.955C16.398 2.923 14.28 2.05 12.008 2.05zm5.132 11.396c-.281-.14-.1.666-.35-.747l-.767-.384c-.281-.14-.5-.14-.687.14l-.516.687c-.187.28-.374.316-.656.176-.28-.14-1.186-.438-2.26-1.4c-.836-.745-1.4-1.664-1.563-1.945-.164-.28-.018-.43.123-.57.127-.126.28-.328.422-.492.14-.164.188-.28.28-.47.094-.187.047-.35-.023-.492-.07-.14-.687-1.656-.941-2.266-.248-.596-.5-.516-.687-.526l-.586-.01c-.203 0-.532.076-.813.384-.28.307-1.07.12-1.07 2.617s1.805 4.906 2.055 5.242c.25.336 3.547 5.42 8.6 7.6 1.2.52 2.14.83 2.87 1.06 1.21.38 2.31.33 3.18.2 1 .15 2.05-.62 2.33-1.22.28-.6.28-1.12.2-1.22-.08-.1-.3-.24-.58-.38z"/></svg>
                            Hubungi Admin via WhatsApp
                        </a>
                        <button onclick="clearRefundNotification()" id="btn-mengerti-refund" class="w-full bg-[#9B76D6] hover:bg-[#8A64A4] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-sm shadow-purple-500/30 text-sm">
                            Mengerti
                        </button>
                    </div>
                </div>
            </div>
            <script>
                function clearRefundNotification() {
                    fetch("{{ route('booking.clear-refund-notification') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    }).then(response => {
                        document.getElementById('refundNotificationModal').remove();
                    }).catch(err => {
                        document.getElementById('refundNotificationModal').remove();
                    });
                }
            </script>
        @endif

        @yield('content')
    </main>

    <!-- Profile Popup & Sidebar Toggle Script -->
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
            const STORAGE_KEY = 'mindflow_sidebar_collapsed';

            function setSidebarState(collapsed, animate) {
                if (!animate) {
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar) sidebar.style.transition = 'none';
                    requestAnimationFrame(function() {
                        if (sidebar) sidebar.style.transition = '';
                    });
                }
                if (collapsed) {
                    document.body.classList.add('sidebar-collapsed');
                    if (expandBtn) expandBtn.classList.add('visible');
                } else {
                    document.body.classList.remove('sidebar-collapsed');
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

    @yield('scripts')
</body>
</html>
