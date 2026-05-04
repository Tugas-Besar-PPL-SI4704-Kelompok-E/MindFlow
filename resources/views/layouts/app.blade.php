<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindFlow - Forum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #a881af; /* Purple accent */
            --primary-light: #f3e8f5;
            --primary-hover: #906698;
            --bg-color: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #f3f4f6;
            --border-dark: #e5e7eb;
            --sidebar-left-w: 260px;
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
        }

        .layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* --- Left Sidebar --- */
        .sidebar-left {
            width: 280px;
            background-color: #FFFFFF;
            border-right: 1px solid var(--border-dark);
            padding: 40px 0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
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
            color: #9B76D6;
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
            color: #9B76D6;
            border-left-color: #9B76D6;
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
            stroke: #9B76D6;
        }

        /* --- Main Content --- */
        .main-content {
            flex: 1;
            border-right: 1px solid var(--border-dark);
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 2px solid var(--border);
        }

        .welcome-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-avatar-lg {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #d1d5db;
        }

        .welcome-text h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2px;
            color: var(--text-main);
        }
        
        .welcome-text p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .search-box {
            position: relative;
        }
        .search-box input {
            padding: 10px 16px 10px 40px;
            border: 1px solid var(--border-dark);
            border-radius: 8px;
            font-size: 0.9rem;
            width: 240px;
            outline: none;
        }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            width: 18px;
            height: 18px;
        }

        /* --- Right Sidebar --- */
        .sidebar-right {
            width: var(--sidebar-right-w);
            padding: 24px;
            position: sticky;
            top: 0;
            height: 100vh;
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
    </style>
</head><body>
    <div class="layout">
        <!-- Sidebar Kiri -->
        <aside class="sidebar-left">
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" style="width: 36px; height: 36px; margin-right: 12px; object-fit: contain;">
                <div>Mind<span class="flow">Flow</span></div>
            </div>
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
                <li style="margin-top: 24px;">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="menu-item" style="width: 100%; background: none; border: none; cursor: pointer; color: #ef4444; text-align: left;">
                            <svg viewBox="0 0 24 24" stroke="#ef4444" fill="none"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content (Tengah) -->
        <main class="main-content">
            <div class="topbar">
                <div class="welcome-section">
                    <div class="user-avatar-lg">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'User') }}&background=e2e8f0&color=1f2937" alt="User" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    </div>
                    <div class="welcome-text">
                        <h2>Welcome, {{ explode(' ', Auth::user()->nama_asli ?? 'User')[0] }}!</h2>
                        <p>How's your day?</p>
                    </div>
                </div>
                <div class="search-box">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari...">
                </div>
            </div>

            @if(session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Sidebar Kanan -->
        <aside class="sidebar-right">
            <div class="right-header">
                <h3>Jadwal Konsultasi Mendatang</h3>
                <a href="#">Batalkan</a>
            </div>
            
            @if(isset($jadwalKonsultasi) && $jadwalKonsultasi->isEmpty())
                <div class="empty-state">
                    <div class="empty-illustration">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p>Tidak ada jadwal ditemukan<br>Ketuk untuk menambahkan jadwal</p>
                </div>
            @elseif(isset($jadwalKonsultasi))
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($jadwalKonsultasi as $jadwal)
                        <div style="background-color: #f9fafb; padding: 16px; border-radius: 12px; border: 1px solid #f3f4f6;">
                            <h4 style="font-weight: 700; font-size: 14px; margin-bottom: 4px;">{{ $jadwal->profilKonselor ? $jadwal->profilKonselor->nama : 'Konselor' }}</h4>
                            <p style="color: #6b7280; font-size: 12px; margin-bottom: 8px;">{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('d M Y, H:i') }}</p>
                            <div style="margin-bottom: 12px;">
                                <span style="display: inline-block; background-color: #fef08a; color: #a16207; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">{{ ucfirst($jadwal->status) }}</span>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('booking.edit', $jadwal->sesi_konseling_id) }}" style="text-decoration: none; font-size: 12px; background-color: #dbeafe; color: #1d4ed8; padding: 4px 12px; border-radius: 4px;">Ubah Jadwal</a>
                                <form action="{{ route('booking.cancel', $jadwal->sesi_konseling_id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan sesi ini?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; cursor: pointer; font-size: 12px; background-color: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 4px;">Batalkan</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-illustration">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p>Tidak ada jadwal ditemukan<br>Ketuk untuk menambahkan jadwal</p>
                </div>
            @endif
        </aside>
    </div>
</body>
</html>
