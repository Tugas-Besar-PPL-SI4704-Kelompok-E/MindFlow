<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Refleksi Mandiri - MindFlow</title>
    <!-- Menggunakan Tailwind CSS via CDN untuk kemudahan styling agar rapi dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom styling sederhana -->
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="text-gray-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar Sederhana -->
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider">MindFlow</h1>
            <nav>
                <!-- Tombol kembali ke dashboard (Bisa disesuaikan dengan route asli aplikasi Anda) -->
                <a href="{{ url('/') }}" class="text-sm font-medium hover:text-indigo-200 transition">Kembali ke Beranda</a>
            </nav>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-grow max-w-5xl mx-auto px-4 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 text-center py-4 mt-auto">
        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} MindFlow - Self-Reflection Journaling</p>
    </footer>

</body>
</html>
