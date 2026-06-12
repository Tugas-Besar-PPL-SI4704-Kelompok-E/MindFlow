<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Konselor - MindFlow')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 text-lg">
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
                        <a href="{{ route('forum.index') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Forum MindFlow
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('konselor.settings') }}" class="flex items-center px-8 py-4 {{ request()->routeIs('konselor.settings') ? 'bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600' : 'text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all' }}">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Pengaturan Profil
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
            <header class="h-24 bg-white border-b border-gray-100 flex items-center justify-between px-10">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">@yield('header', 'Ruang Kerja Dokter')</h2>
                <div class="flex items-center space-x-4">
                    <div class="text-right mr-2">
                        <div class="font-bold text-gray-800">{{ explode(' ', Auth::user()->nama_asli ?? 'Dokter')[0] }}</div>
                        <div class="text-sm text-gray-500">Konselor</div>
                    </div>
                    <img class="h-12 w-12 rounded-full border-2 border-purple-200 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Konselor') }}&background=f3e8ff&color=6b21a8" alt="Konselor">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-10">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
