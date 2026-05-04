<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Spesialisasi - MindFlow Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar-link { display:flex; align-items:center; padding:14px 30px; font-weight:600; font-size:15px; color:#1A1A1A; text-decoration:none; border-left:4px solid transparent; transition:all .2s; }
        .sidebar-link:hover { background:#F9F9F9; }
        .sidebar-link.active { background:#F4EEFB; color:#9B76D6; border-left-color:#9B76D6; }
        .sidebar-link svg { width:22px; height:22px; margin-right:14px; stroke:currentColor; stroke-width:2; fill:none; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-900">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-[280px] bg-white border-r border-gray-200 flex flex-col flex-shrink-0">
            <div class="flex items-center h-[80px] px-8 border-b border-gray-100">
                <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" class="w-9 h-9 mr-3 object-contain">
                <h1 class="text-[22px] font-bold text-[#1A1A1A]">Mind<span class="text-[#9B76D6]">Flow</span></h1>
            </div>
            <nav class="flex-1 overflow-y-auto py-6">
                <ul class="flex flex-col gap-1">
                    <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Laporan & Moderasi</a></li>
                    <li><a href="{{ route('admin.spesialisasi') }}" class="sidebar-link active">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Spesialisasi</a></li>
                    <li><a href="{{ route('forum.index') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Forum MindFlow</a></li>
                    <li class="mt-6">
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="sidebar-link w-full text-left" style="color:#ef4444; background:none; border:none; cursor:pointer;">
                                <svg viewBox="0 0 24 24" stroke="#ef4444"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-[72px] bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-800">Kelola Spesialisasi</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Admin' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Admin') }}&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-base font-bold text-gray-800">Daftar Kategori Spesialisasi</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Kelola kategori spesialisasi yang tersedia untuk konselor.</p>
                    </div>
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold">#</th>
                                <th class="px-6 py-4 font-semibold">Nama Spesialisasi</th>
                                <th class="px-6 py-4 font-semibold">Jumlah Konselor</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php
                                $spesialisasiList = [
                                    ['nama' => 'Kesehatan Mental', 'jumlah' => 5, 'status' => 'Aktif'],
                                    ['nama' => 'Konseling Akademik', 'jumlah' => 3, 'status' => 'Aktif'],
                                    ['nama' => 'Karir', 'jumlah' => 2, 'status' => 'Aktif'],
                                    ['nama' => 'Klinis & Depresi', 'jumlah' => 4, 'status' => 'Aktif'],
                                    ['nama' => 'Konseling Remaja', 'jumlah' => 1, 'status' => 'Aktif'],
                                    ['nama' => 'Konseling Keluarga', 'jumlah' => 0, 'status' => 'Nonaktif'],
                                ];
                            @endphp
                            @foreach($spesialisasiList as $i => $s)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-bold text-gray-400">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $s['nama'] }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $s['jumlah'] }} Konselor</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $s['status'] === 'Aktif' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $s['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
