<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MindFlow Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-8 py-4 bg-purple-100 text-purple-800 font-bold border-l-4 border-purple-600">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.rekrutmen') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Rekrutmen Konselor
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan') }}" class="flex items-center px-8 py-4 text-gray-700 hover:bg-purple-50 hover:text-purple-700 font-semibold transition-all">
                            <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Laporan & Moderasi
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <header class="h-24 bg-white border-b border-gray-100 flex items-center justify-between px-10">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Ringkasan Sistem</h2>
                <div class="flex items-center space-x-4">
                    <img class="h-12 w-12 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name=Admin&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-10">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between">
                        <div class="text-gray-500 font-semibold mb-2">Artikel Terbit</div>
                        <div class="flex items-baseline justify-between">
                            <div class="text-5xl font-black text-gray-900">{{ $totalArticles }}</div>
                            <div class="p-4 bg-green-50 text-green-600 rounded-2xl">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between">
                        <div class="text-gray-500 font-semibold mb-2">Laporan Pelanggaran</div>
                        <div class="flex items-baseline justify-between">
                            <div class="text-5xl font-black text-red-600">{{ $totalReports }}</div>
                            <div class="p-4 bg-red-50 text-red-600 rounded-2xl">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 mb-10">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Statistik Aktivitas</h3>
                            <p class="text-gray-500 text-base">Tren pertumbuhan pengguna MindFlow selama seminggu terakhir.</p>
                        </div>
                    </div>
                    <div class="h-96">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between">
                        <div class="text-gray-500 font-semibold mb-2">Total Pengguna</div>
                        <div class="flex items-baseline justify-between">
                            <div class="text-4xl font-bold text-gray-800">{{ $totalUsers }}</div>
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-between">
                        <div class="text-gray-500 font-semibold mb-2">Pendaftar Konselor</div>
                        <div class="flex items-baseline justify-between">
                            <div class="text-4xl font-bold text-purple-700">{{ $totalApplicants }}</div>
                            <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Pengguna Baru',
                    data: [12, 19, 15, 25, 22, 30, 45],
                    borderColor: '#6b21a8',
                    backgroundColor: 'rgba(107, 33, 168, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#6b21a8'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>