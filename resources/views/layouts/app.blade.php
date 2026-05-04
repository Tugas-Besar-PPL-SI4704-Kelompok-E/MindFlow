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
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background-color: #F9F9F9;
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
    <div class="layout">
        <!-- Sidebar Kiri -->
        <aside class="sidebar-left">
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" style="width: 36px; height: 36px; margin-right: 12px; object-fit: contain;">
                <div>Mind<span class="flow">Flow</span></div>
            </div>
            
            <div class="menu-title">Menu</div>
            <ul class="menu-list">
                @if(Auth::check() && Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->is('admin*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard Admin
                    </a>
                </li>
                @endif
                @if(Auth::check() && Auth::user()->role === 'konselor')
                <li>
                    <a href="{{ route('konselor.dashboard') }}" class="menu-item {{ request()->is('konselor*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Dashboard Konselor
                    </a>
                </li>
                @endif
                @if(!Auth::check() || !in_array(Auth::user()->role, ['admin', 'konselor']))
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
                @endif
                <li>
                    <a href="{{ route('forum.index') }}" class="menu-item {{ request()->is('forum*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Forum
                    </a>
                </li>
                @if(!Auth::check() || !in_array(Auth::user()->role, ['admin', 'konselor']))
                <li>
                    <a href="{{ route('journals.index') }}" class="menu-item {{ request()->is('journals*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        Jurnal
                    </a>
                </li>
                <li>
                    <a href="#" class="menu-item {{ request()->is('artikel*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
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

            @yield('content')
        </main>

        <!-- Sidebar Kanan -->
        <aside class="sidebar-right">
            <div class="right-header">
                <h3 class="text-gray-900 font-bold">Jadwal Konsultasi</h3>
                <a href="#" class="text-[#A881C2] hover:text-[#8A64A4] font-bold text-xs transition-colors">Lihat Semua</a>
            </div>
            
            @if(isset($jadwalKonsultasi) && $jadwalKonsultasi->where('status', '!=', 'cancelled')->isEmpty())
                <div class="empty-state">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100 shadow-inner">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-300"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-[13px] font-medium text-gray-400">Belum ada jadwal<br>konsultasi aktif</p>
                </div>
            @elseif(isset($jadwalKonsultasi))
                <div class="flex flex-col gap-5">
                    @foreach($jadwalKonsultasi->where('status', '!=', 'cancelled') as $jadwal)
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
                            
                            <div class="mb-5">
                                @php
                                    $statusColor = match($jadwal->status) {
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'rescheduled' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'confirmed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        default => 'bg-gray-50 text-gray-600 border-gray-100'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 {{ $statusColor }} border rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ $jadwal->status }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('booking.edit', $jadwal->sesi_konseling_id) }}" class="flex-1 text-center bg-gray-50 hover:bg-purple-50 hover:text-[#A881C2] text-gray-500 py-2.5 rounded-xl text-[11px] font-bold transition-all duration-300 border border-transparent hover:border-purple-100">
                                    Ubah
                                </a>
                                <form action="{{ route('booking.cancel', $jadwal->sesi_konseling_id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan sesi ini?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-gray-50 hover:bg-red-50 hover:text-red-500 text-gray-500 py-2.5 rounded-xl text-[11px] font-bold transition-all duration-300 border border-transparent hover:border-red-100">
                                        Batal
                                    </button>
                                </form>
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
    </div>

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
    @stack('scripts')
</body>
</html>
