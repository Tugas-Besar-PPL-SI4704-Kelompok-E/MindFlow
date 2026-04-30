<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindFlow - Forum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .layout {
            display: flex;
            max-width: 1300px;
            margin: 0 auto;
            min-height: 100vh;
        }

        /* --- Left Sidebar --- */
        .sidebar-left {
            width: var(--sidebar-left-w);
            border-right: 1px solid var(--border-dark);
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 24px;
            margin-bottom: 32px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            background: #1e1b4b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .logo-icon::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background: #a881af;
            border-radius: 50%;
            bottom: -4px;
            right: -4px;
        }

        .menu-title {
            padding: 0 24px;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 16px;
            margin-top: 10px;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 24px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .nav-item:hover {
            background-color: #f9fafb;
        }

        .nav-item.active {
            background-color: var(--primary-light);
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
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
</head>
<body>
    <div class="layout">
        <!-- Sidebar Kiri -->
        <aside class="sidebar-left">
            <div class="logo">
                <div class="logo-icon"></div>
                MindFlow
            </div>
            
            <div class="menu-title">Menu</div>
            
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('homepage') }}" class="nav-item">
                        <svg class="nav-icon" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Homepage
                    </a>
                </li>
                <li>
                    <a href="{{ route('konseling.index') }}" class="nav-item">
                        <svg class="nav-icon" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Konsultasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('forum.index') }}" class="nav-item active">
                        <svg class="nav-icon" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Forum
                    </a>
                </li>
                <li>
                    <a href="{{ route('journals.index') }}" class="nav-item">
                        <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Jurnal
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item">
                        <svg class="nav-icon" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Artikel
                    </a>
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
            
            <div class="empty-state">
                <div class="empty-illustration">
                    <!-- Placeholder Illustration -->
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <p>Tidak ada jadwal ditemukan<br>Ketuk untuk menambahkan jadwal</p>
            </div>
        </aside>
    </div>
</body>
</html>
