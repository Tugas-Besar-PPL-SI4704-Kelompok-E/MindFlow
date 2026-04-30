<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Spesialisasi - MindFlow Admin</title>
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
                    <li><a href="{{ route('admin.dashboard') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>Laporan & Moderasi</a></li>
                    <li><a href="{{ route('admin.spesialisasi') }}" class="flex items-center px-8 py-4 bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600"><svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>Spesialisasi</a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <header class="h-24 bg-white border-b border-gray-100 flex items-center justify-between px-10">
                <h2 class="text-3xl font-bold text-gray-800">Kelola Spesialisasi Konselor</h2>
            </header>

            <main class="flex-1 overflow-y-auto p-10">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Daftar Kategori Spesialisasi</h3>
                            <p class="text-gray-500 text-sm mt-1">Kelola kategori spesialisasi yang tersedia untuk konselor.</p>
                        </div>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-purple-50 text-purple-900 text-sm font-bold uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-5">#</th>
                                <th class="px-8 py-5">Nama Spesialisasi</th>
                                <th class="px-8 py-5">Jumlah Konselor</th>
                                <th class="px-8 py-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
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
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-5 font-bold text-gray-400">{{ $i + 1 }}</td>
                                <td class="px-8 py-5 font-bold text-gray-800">{{ $s['nama'] }}</td>
                                <td class="px-8 py-5 text-gray-600">{{ $s['jumlah'] }} Konselor</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $s['status'] === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
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
