<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Laporan - MindFlow Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 text-lg">
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-72 bg-white border-r border-gray-200 flex flex-col">
            <div class="flex items-center h-24 px-8 border-b border-gray-100">
                <svg class="w-10 h-10 text-purple-900 mr-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">MindFlow</h1>
            </div>

            <nav class="flex-1 overflow-y-auto py-8">
                <div class="px-8 mb-6 text-xl font-bold text-gray-900">Menu</div>
                <ul class="space-y-3">
                    <li><a href="{{ route('admin.dashboard') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="flex items-center px-8 py-4 bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>Laporan & Moderasi</a></li>
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

        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <header class="h-24 bg-white border-b border-gray-100 flex items-center justify-between px-10">
                <h2 class="text-3xl font-bold text-gray-800">Laporan Pelanggaran</h2>
            </header>

            <main class="flex-1 overflow-y-auto p-10">
                @if(session('success'))
                <div class="mb-8 p-6 bg-green-100 border-l-8 border-green-500 text-green-800 font-bold rounded-r-xl shadow-sm text-xl">
                    {{ session('success') }}
                </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-red-50 text-red-900 text-sm font-bold uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-6">Isi Postingan</th>
                                <th class="px-8 py-6">Alasan</th>
                                <th class="px-8 py-6 text-center">Aksi Permanen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-6 w-1/2">
                                    <div class="text-gray-400 text-xs mb-1 uppercase font-bold">Dilaporkan oleh: {{ $report->pelapor->nama_samaran ?? ($report->pelapor->nama_asli ?? 'Tidak diketahui') }}</div>
                                    <div class="text-lg italic text-gray-700">"{{ $report->konten }}"</div>
                                    <div class="text-xs text-gray-400 mt-1 uppercase">{{ $report->type === 'thread' ? 'Postingan' : 'Balasan' }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-black uppercase italic">
                                        {{ $report->alasan }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        @if(!$report->is_deleted)
                                        <form action="{{ route('admin.forum.delete', ['id' => $report->target_id, 'type' => $report->type]) }}" method="POST" onsubmit="return confirm('Hapus {{ $report->type === 'thread' ? 'postingan' : 'balasan' }} ini secara PERMANEN?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-4 bg-red-600 text-white rounded-2xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all transform hover:scale-110">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-gray-400 text-sm">Sudah dihapus</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center text-gray-400 text-lg">Tidak ada laporan pelanggaran. 🎉</td>
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