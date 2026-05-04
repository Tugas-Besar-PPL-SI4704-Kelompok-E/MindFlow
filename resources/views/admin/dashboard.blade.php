<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MindFlow Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar-link { display:flex; align-items:center; padding:14px 30px; font-weight:600; font-size:15px; color:#1A1A1A; text-decoration:none; border-left:4px solid transparent; transition:all .2s; }
        .sidebar-link:hover { background:#F9F9F9; }
        .sidebar-link.active { background:#F4EEFB; color:#9B76D6; border-left-color:#9B76D6; }
        .sidebar-link svg { width:22px; height:22px; margin-right:14px; stroke:currentColor; stroke-width:2; fill:none; }
        .stat-card { background:#fff; border-radius:16px; padding:24px; border:1px solid #f3f4f6; transition:transform .2s,box-shadow .2s; }
        .stat-card:hover { transform:translateY(-4px); box-shadow:0 8px 25px rgba(0,0,0,.08); }
        .gradient-header { background:linear-gradient(135deg,#7c3aed 0%,#a78bfa 50%,#c4b5fd 100%); border-radius:20px; padding:28px 32px; color:#fff; position:relative; overflow:hidden; }
        .gradient-header::before { content:''; position:absolute; top:-40px; right:-40px; width:160px; height:160px; background:rgba(255,255,255,.1); border-radius:50%; }
        .gradient-header::after { content:''; position:absolute; bottom:-60px; right:80px; width:200px; height:200px; background:rgba(255,255,255,.06); border-radius:50%; }
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
                    <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Laporan & Moderasi</a></li>
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
            {{-- Top Bar --}}
            <header class="h-[72px] bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-800">Dashboard Admin</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Admin' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Admin') }}&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                {{-- Welcome Header --}}
                <div class="gradient-header mb-8">
                    <p class="text-purple-100 text-sm mb-1">Selamat datang kembali 👋</p>
                    <h2 class="text-2xl font-bold relative z-10">{{ Auth::user()->nama_asli ?? 'Admin' }}</h2>
                    <p class="text-purple-200 text-sm mt-1 relative z-10">Berikut ringkasan aktivitas platform MindFlow hari ini.</p>
                    <div class="flex gap-6 mt-5 relative z-10">
                        <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3 text-center">
                            <div class="text-2xl font-extrabold">{{ $totalUsers }}</div>
                            <div class="text-xs text-purple-100">Pengguna</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3 text-center">
                            <div class="text-2xl font-extrabold">{{ $totalKonselor }}</div>
                            <div class="text-xs text-purple-100">Konselor</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur rounded-xl px-5 py-3 text-center">
                            <div class="text-2xl font-extrabold">{{ $totalSessions }}</div>
                            <div class="text-xs text-purple-100">Sesi Konseling</div>
                        </div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-500">Total Pengguna</span>
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $totalUsers }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-500">Forum Post</span>
                            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $totalThreads }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-500">Jurnal Ditulis</span>
                            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $totalJournals }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-semibold text-gray-500">Laporan</span>
                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="text-3xl font-extrabold {{ $totalReports > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $totalReports }}</div>
                    </div>
                </div>

                {{-- Chart + Recent Reports --}}
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
                    <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-base font-bold text-gray-800 mb-1">Pertumbuhan Pengguna</h3>
                        <p class="text-xs text-gray-400 mb-4">Pendaftaran pengguna baru 7 hari terakhir</p>
                        <div class="h-[260px]"><canvas id="userGrowthChart"></canvas></div>
                    </div>
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-base font-bold text-gray-800 mb-4">Laporan Terbaru</h3>
                        @if($recentReports->isEmpty())
                            <div class="flex flex-col items-center justify-center h-[220px] text-gray-400">
                                <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm">Tidak ada laporan 🎉</p>
                            </div>
                        @else
                            <div class="flex flex-col gap-3 max-h-[260px] overflow-y-auto">
                                @foreach($recentReports as $r)
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-red-50/50 border border-red-100">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-gray-700 truncate">"{{ Str::limit($r->thread->content ?? 'Dihapus', 50) }}"</p>
                                        <p class="text-[11px] text-gray-400 mt-1">{{ $r->reason }} · {{ $r->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                        <a href="{{ route('admin.laporan') }}" class="mt-4 inline-block text-xs font-semibold text-purple-600 hover:text-purple-800">Lihat Semua →</a>
                    </div>
                </div>

                {{-- Recent Forum Posts --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-bold text-gray-800">Postingan Forum Terbaru</h3>
                        <a href="{{ route('forum.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-800">Lihat Forum →</a>
                    </div>
                    @if($recentThreads->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-8">Belum ada postingan forum.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead><tr class="text-xs uppercase text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-semibold">Pengguna</th>
                                <th class="pb-3 font-semibold">Konten</th>
                                <th class="pb-3 font-semibold">Waktu</th>
                            </tr></thead>
                            <tbody>
                            @foreach($recentThreads as $t)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2">
                                            <img class="w-7 h-7 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($t->user->nama_asli ?? 'User') }}&background=e9d5ff&color=6b21a8&size=28" alt="">
                                            <span class="font-semibold text-gray-700 text-xs">{{ $t->user->role === 'user' ? 'Anonim' : ($t->user->nama_asli ?? 'User') }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600 text-xs">{{ Str::limit($t->content, 80) }}</td>
                                    <td class="py-3 text-gray-400 text-xs whitespace-nowrap">{{ $t->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('userGrowthChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(139, 92, 246, 0.25)');
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($userGrowth)->pluck('label')) !!},
                datasets: [{
                    label: 'Pengguna Baru',
                    data: {!! json_encode(collect($userGrowth)->pluck('count')) !!},
                    borderColor: '#8b5cf6',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { borderDash: [4,4], color: '#f3f4f6' } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    </script>
</body>
</html>