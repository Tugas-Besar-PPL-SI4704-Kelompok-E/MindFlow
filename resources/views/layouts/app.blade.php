<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindFlow</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA;
        }
        /* Custom scrollbar for sidebar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="text-gray-800 antialiased h-screen flex overflow-hidden">

    <!-- Left Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0">
        <!-- Logo -->
        <div class="h-24 flex items-center px-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-900 to-indigo-500 flex items-center justify-center">
                    <!-- Logo mark placeholder -->
                    <svg class="w-5 h-5 text-white transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">MindFlow</span>
            </div>
        </div>

        <!-- Menu -->
        <div class="px-4 py-4 flex-1 overflow-y-auto">
            <h3 class="px-4 text-sm font-semibold text-gray-900 mb-4">Menu</h3>
            <nav class="space-y-2">
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Homepage</span>
                </a>
                <a href="{{ route('konseling.index') }}" class="flex items-center gap-4 px-4 py-3 bg-[#F3E8FF] text-[#6B21A8] font-bold rounded-lg transition border-l-4 border-[#8B5CF6]">
                    <svg class="w-5 h-5 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Konsultasi</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Forum</span>
                </a>
                <a href="{{ route('journals.index') }}" class="flex items-center gap-4 px-4 py-3 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Jurnal</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Artikel</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-white">
        <!-- Top Header -->
        <header class="h-28 px-8 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-4">
                <img src="https://ui-avatars.com/api/?name=Asep&background=EBF4FF&color=4F46E5&rounded=true&size=64" alt="Profile" class="w-16 h-16 rounded-full shadow-sm">
                <div>
                    <h2 class="text-[26px] font-bold text-gray-900 leading-tight">Welcome, Asep!</h2>
                    <p class="text-gray-500 text-sm font-medium mt-1">How's your day?</p>
                </div>
            </div>
            
            <div class="relative w-80">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] transition-shadow" placeholder="Cari...">
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-1 overflow-y-auto px-8 pb-8">
            @yield('content')
        </div>
    </main>

    <!-- Right Sidebar (Schedule) -->
    <aside class="w-80 bg-white border-l border-gray-200 flex flex-col flex-shrink-0 shadow-[-5px_0_15px_-10px_rgba(0,0,0,0.05)] z-10">
        <div class="p-8">
            <div class="flex justify-between items-center mb-10">
                <h3 class="font-bold text-gray-900 text-[15px]">Jadwal Konsultasi Mendatang</h3>
                <a href="#" class="text-[13px] text-[#A881C2] hover:text-purple-800 font-medium">Batalkan</a>
            </div>
            
            <div class="flex flex-col items-center justify-center mt-20 text-center">
                <!-- Fallback to a nicely styled avatar if image fails -->
                <img src="https://ui-avatars.com/api/?name=Schedule&background=F3E8FF&color=8B5CF6&size=150&font-size=0.33" alt="Empty Schedule" class="w-48 h-48 mb-8 object-contain opacity-90 hover:opacity-100 transition-opacity">
                <p class="text-[13px] text-gray-500 font-medium leading-relaxed max-w-[200px]">Tidak ada jadwal ditemukan<br>Ketuk untuk menambahkan jadwal</p>
            </div>
        </div>
    </aside>

</body>
</html>
