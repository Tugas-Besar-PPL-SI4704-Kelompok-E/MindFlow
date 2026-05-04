<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Laporan - MindFlow Admin</title>
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
            <nav class="flex-1 overflow-y-auto py-6 flex flex-col">
                <ul class="flex flex-col gap-1">
                    <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="sidebar-link active">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Laporan & Moderasi</a></li>
                    <li><a href="{{ route('forum.index') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Forum MindFlow</a></li>
                </ul>
                <div class="mt-auto border-t border-gray-100 pt-4">
                    <a href="{{ route('settings.edit') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Settings</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left" style="color:#ef4444; background:none; border:none; cursor:pointer;">
                            <svg viewBox="0 0 24 24" stroke="#ef4444"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar</button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-[72px] bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-800">Laporan & Moderasi</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Admin' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Admin') }}&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                {{-- Summary --}}
                <div class="grid grid-cols-2 gap-5 mb-8">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold {{ $reports->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $reports->count() }}</div>
                            <div class="text-xs text-gray-500 font-medium">Total Laporan</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold text-orange-600">{{ $reports->where('is_deleted', false)->count() }}</div>
                            <div class="text-xs text-gray-500 font-medium">Perlu Ditindak</div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-base font-bold text-gray-800">Daftar Laporan Pelanggaran</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Tindak lanjuti laporan dari pengguna forum</p>
                    </div>
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Isi Postingan</th>
                                <th class="px-6 py-4 font-semibold">Alasan</th>
                                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 w-1/2">
                                    <div class="text-[11px] text-gray-400 uppercase font-semibold mb-1">Dilaporkan oleh: {{ $report->pelapor->nama_samaran ?? ($report->pelapor->nama_asli ?? 'Tidak diketahui') }}</div>
                                    <div class="text-sm text-gray-700 italic">"{{ Str::limit($report->konten, 100) }}"</div>
                                    <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $report->type === 'thread' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500' }}">{{ $report->type === 'thread' ? 'Postingan' : 'Balasan' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold">{{ $report->alasan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        @if(!$report->is_deleted)
                                        <form action="{{ route('admin.forum.delete', ['id' => $report->target_id, 'type' => $report->type]) }}" method="POST" onsubmit="return confirm('Hapus {{ $report->type === 'thread' ? 'postingan' : 'balasan' }} ini secara PERMANEN?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                        @else
                                        <span class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs font-semibold">Sudah dihapus</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-400 text-sm">Tidak ada laporan pelanggaran. 🎉</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>