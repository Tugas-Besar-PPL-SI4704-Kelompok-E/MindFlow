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
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background-color: #F9F9F9;
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
            background-color: var(--active-bg);
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
<<<<<<< HEAD
    @if(Auth::check() && Auth::user()->role === 'admin')
    <style>
        .brand span.flow {
            color: #9B76D6 !important;
        }
        .menu-item {
            padding: 14px 30px !important;
        }
        .menu-item svg {
            width: 22px !important;
            height: 22px !important;
            margin-right: 14px !important;
        }
        .menu-item.active {
            background-color: #F4EEFB !important;
            color: #9B76D6 !important;
            border-left-color: #9B76D6 !important;
        }
        .menu-item.active svg {
            stroke: #9B76D6 !important;
        }
    </style>
    @endif
=======
>>>>>>> 12c28e0 (merge)
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    @if(!isset($hideSidebar) || !$hideSidebar)
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" style="width: 36px; height: 36px; margin-right: 12px; object-fit: contain;">
            <div>Mind<span class="flow">Flow</span></div>
        </div>

        <div class="menu-title">Menu</div>
        <ul class="menu-list">
            @if(Auth::check() && Auth::user()->role === 'admin')
            {{-- Admin Menu --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rekrutmen') }}" class="menu-item {{ request()->is('admin/rekrutmen*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Rekrutmen Konselor
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laporan') }}" class="menu-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Laporan & Moderasi
                </a>
            </li>
            <li>
                <a href="{{ route('admin.spesialisasi') }}" class="menu-item {{ request()->is('admin/spesialisasi*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Spesialisasi
                </a>
            </li>
            <li>
                <a href="{{ route('forum.index') }}" class="menu-item {{ request()->is('forum*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Forum MindFlow
                </a>
            </li>
            <li>
                <a href="{{ route('artikel.index') }}" class="menu-item {{ request()->is('artikel*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                    Artikel
                </a>
            </li>
            <li>
                <a href="{{ route('admin.faq') }}" class="menu-item {{ request()->is('admin/faq*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    FAQ
                </a>
            </li>
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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Forum
                </a>
            </li>
            <li>
                <a href="{{ route('artikel.index') }}" class="menu-item {{ request()->is('artikel*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
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

        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="mt-auto border-t border-gray-100 pt-4 pb-4">
                <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->is('admin/settings*') ? 'active' : '' }}" style="display: flex; align-items: center; width: 100%;">
                    <svg viewBox="0 0 24 24" style="margin-right: 16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="menu-item w-full text-left" style="color:#ef4444; background:none; border:none; cursor:pointer; display:flex; align-items:center;">
                        <svg viewBox="0 0 24 24" stroke="#ef4444" fill="none" style="margin-right: 16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <!-- Spacer to push profile to bottom -->
            <div class="sidebar-spacer"></div>

            <!-- Profile Section -->
            <div class="sidebar-profile-section" id="profileSection">
                <!-- Popup Menu -->
                <div class="sidebar-popup" id="profilePopup">
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
                </div>

                <!-- Profile Button -->
                <button class="sidebar-profile-btn" id="profileBtn" type="button">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_samaran ?? 'User') }}&background=E8DEFA&color=6B3FA0&size=42&font-size=0.4&bold=true" alt="Profile" class="sidebar-profile-avatar">
                    <div class="sidebar-profile-info">
                        <div class="sidebar-profile-name">{{ Auth::user()->nama_samaran ?? 'User' }}</div>
                        <div class="sidebar-profile-role">{{ ucfirst(Auth::user()->role ?? 'Mahasiswa') }}</div>
                    </div>
                    <svg class="sidebar-profile-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
            </div>
        @endif
    </aside>
    @endif

    <!-- MAIN CONTENT -->
    <main class="main-content">
        @if(!request()->is('home'))
        <div class="header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_samaran ?? 'User') }}&background=E2E8F0&color=475569&size=65" alt="Profile" class="avatar">
            <div class="welcome-text">
                <h1>Welcome, {{ Auth::user()->nama_asli ?? 'User' }}!</h1>
                <p>How's your day?</p>
            </div>
        </div>
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

        @yield('content')
    </main>

    <!-- Profile Popup Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.getElementById('profileBtn');
            const profilePopup = document.getElementById('profilePopup');

            if (profileBtn && profilePopup) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profilePopup.classList.toggle('show');
                    profileBtn.classList.toggle('open');
                });

                // Close popup when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#profileSection')) {
                        profilePopup.classList.remove('show');
                        profileBtn.classList.remove('open');
                    }
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
