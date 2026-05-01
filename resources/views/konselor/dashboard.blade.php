<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Konselor - MindFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <a href="{{ route('konselor.dashboard') }}" class="flex items-center px-8 py-4 bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Jadwal Konseling
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Daftar Pasien
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forum.index') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Forum MindFlow
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
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Ruang Kerja Dokter</h2>
                <div class="flex items-center space-x-4">
                    <div class="text-right mr-2">
                        <div class="font-bold text-gray-800">{{ explode(' ', Auth::user()->nama_asli ?? 'Dokter')[0] }}</div>
                        <div class="text-sm text-gray-500">Konselor</div>
                    </div>
                    <img class="h-12 w-12 rounded-full border-2 border-purple-200 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Konselor') }}&background=f3e8ff&color=6b21a8" alt="Konselor">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-10">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat datang, Dokter!</h3>
                        <p class="text-gray-500">
                            Ini adalah dashboard khusus konselor. Anda dapat mengelola jadwal konseling, melihat daftar pasien, dan merespon thread di forum MindFlow.
                            <br>Saat Anda memposting atau merespon di forum, badge khusus <strong>Dokter</strong> akan otomatis ditambahkan ke nama Anda.
                        </p>
                    </div>
                    <div class="hidden lg:block text-purple-200">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between">
                        <div class="text-gray-500 font-semibold mb-2">Sesi Konseling Hari Ini</div>
                        <div class="flex items-baseline justify-between">
                            <div class="text-5xl font-black text-gray-900">3</div>
                            <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between">
                        <div class="text-gray-500 font-semibold mb-2">Pasien Aktif</div>
                        <div class="flex items-baseline justify-between">
                            <div class="text-5xl font-black text-blue-600">12</div>
                            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex justify-center">
                    <a href="{{ route('forum.index') }}" class="flex items-center px-8 py-4 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-all shadow-lg shadow-purple-200">
                        Menuju Forum MindFlow
                        <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
