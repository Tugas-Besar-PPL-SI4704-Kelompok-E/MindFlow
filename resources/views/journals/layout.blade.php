<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Refleksi Mandiri - MindFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; color: #1F2937; }
        /* Sidebar active link styling */
        .sidebar-link { padding: 12px 24px; display: flex; align-items: center; color: #111827; font-weight: 700; font-size: 14px; transition: all 0.2s; border-left: 4px solid transparent; }
        .sidebar-link:hover { background-color: #F8FAFC; }
        .sidebar-link.active { background-color: #F3E8FF; border-left-color: #9333EA; color: #7E22CE; }
        .sidebar-link svg { margin-right: 16px; width: 22px; height: 22px; stroke-width: 2.5; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E0E0E0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #BDBDBD; }
    </style>
</head>
<body class="antialiased min-h-screen flex h-screen overflow-hidden">

    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-200 flex-shrink-0 flex flex-col hidden md:flex sticky top-0 h-screen z-10 pt-4">
        <div class="px-8 py-4 flex items-center space-x-3 mb-6">
            <!-- MindFlow Logo -->
            <div class="bg-[#1e1b4b] rounded-full w-9 h-9 flex items-center justify-center overflow-hidden flex-shrink-0">
                <svg viewBox="0 0 100 100" class="w-6 h-6 text-white" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 50C20 50 35 25 50 50C65 75 80 50 80 50" stroke="currentColor" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1 class="text-[22px] font-extrabold tracking-tight text-[#111827]">MindFlow</h1>
        </div>
        
        <div class="flex-grow">
            <h2 class="text-[16px] font-extrabold text-[#111827] px-8 mb-4">Menu</h2>
            <nav class="flex flex-col space-y-1">
                <a href="{{ route('homepage') }}" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Homepage
                </a>
                <a href="#" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Konsultasi
                </a>
                <a href="#" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Forum
                </a>
                <!-- Active Item: Jurnal -->
                <a href="{{ route('journals.index') }}" class="sidebar-link active">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Jurnal
                </a>
                <a href="#" class="sidebar-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Artikel
                </a>
            </nav>
        </div>
    </aside>

    <!-- App Content Wrapper -->
    <main class="flex-grow flex bg-white overflow-hidden">
        @yield('content')
    </main>

</body>
</html>
