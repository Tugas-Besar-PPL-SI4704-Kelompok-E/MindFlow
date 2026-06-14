<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Konselor - MindFlow')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .konselor-sidebar {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-collapsed-konselor .konselor-sidebar {
            margin-left: -288px; /* w-72 = 18rem = 288px */
        }
        .floating-expand-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 99;
            width: 44px;
            height: 44px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(107, 33, 168, 0.1);
            transition: all 0.3s ease;
        }
        .floating-expand-btn.visible { display: flex; }
        .floating-expand-btn:hover {
            transform: scale(1.05);
            background: #f3e8ff;
            border-color: #6b21a8;
        }
        .sidebar-nav-link {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s, color 0.2s;
            transform-origin: left center;
        }
        .sidebar-nav-link:hover {
            transform: scale(1.04) translateX(4px);
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
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 text-lg relative">
    <div class="ambient-blob ambient-blob-1"></div>
    <div class="ambient-blob ambient-blob-2"></div>
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Kiri -->
        <aside class="w-72 bg-white border-r border-gray-200 flex flex-col">
            <div class="flex items-center h-24 px-8 border-b border-gray-100">
                <svg class="w-10 h-10 text-purple-900 mr-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">MindFlow</h1>
            </div>

            <nav class="flex-1 overflow-y-auto py-8">
                <div class="px-8 mb-6 text-xl font-bold text-gray-900">Menu Konselor</div>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('konselor.dashboard') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('konselor.dashboard') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('konselor.jadwal') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('konselor.jadwal') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Jadwal Konseling
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('konselor.counselor-schedules.index') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('konselor.counselor-schedules.*') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Ketersediaan Waktu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('konselor.pasien') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('konselor.pasien') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Daftar Pasien
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('konselor.dompet') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('konselor.dompet') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Dompet & Pencairan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forum.index') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('forum.*') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Forum MindFlow
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('artikel.index') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('artikel.*') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                            Artikel
                        </a>
                    </li>

                    <li style="margin-top: 24px;">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="flex items-center px-8 py-4 w-full text-red-600 hover:bg-red-50 hover:text-red-700 font-semibold transition-all cursor-pointer text-left" style="background: none; border: none;">
                                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <header class="h-[72px] bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-800">@yield('header', 'Ruang Kerja Dokter')</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Konselor' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Konselor') }}&background=f3e8ff&color=6b21a8" alt="Konselor">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
