<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQ - MindFlow</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        details > summary {
            list-style: none;
        }
        details > summary::-webkit-details-marker {
            display: none;
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="font-bold text-2xl tracking-tight text-teal-900">MindFlow</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="/" class="text-slate-600 hover:text-teal-600 font-medium transition">Home</a>
                    @auth
                        <a href="{{ route('settings.edit') }}" class="text-slate-600 hover:text-teal-600 font-medium transition">Settings</a>
                    @endauth
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-5 py-2.5 rounded-full font-medium transition border border-rose-200">
                                Log out
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-slate-600 hover:text-teal-600 font-medium transition">Log in</a>
                        <a href="/register" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-teal-200">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto min-h-screen">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-slate-900 mb-4">Frequently Asked Questions</h1>
            <p class="text-lg text-slate-600">Got a question? We've got answers. If you have some other questions, feel free to contact us.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <details class="group bg-white rounded-2xl shadow-sm border border-slate-100 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-slate-900">
                    <h2 class="font-semibold text-lg">Apa itu MindFlow?</h2>
                    <span class="relative h-5 w-5 shrink-0">
                        <svg class="absolute inset-0 opacity-100 group-open:opacity-0 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg class="absolute inset-0 opacity-0 group-open:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                    MindFlow adalah platform kesejahteraan mental yang dirancang untuk membantu Anda melacak suasana hati, berlatih mindfulness, dan terhubung dengan konselor profesional.
                </div>
            </details>

            <!-- FAQ Item 2 -->
            <details class="group bg-white rounded-2xl shadow-sm border border-slate-100 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-slate-900">
                    <h2 class="font-semibold text-lg">Apakah data dan privasi saya aman?</h2>
                    <span class="relative h-5 w-5 shrink-0">
                        <svg class="absolute inset-0 opacity-100 group-open:opacity-0 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg class="absolute inset-0 opacity-0 group-open:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                    Tentu saja. Privasi pengguna adalah prioritas utama kami. Kami menggunakan nama samaran (pseudonym) dan enkripsi standar industri untuk melindungi seluruh percakapan dan data pribadi Anda.
                </div>
            </details>

            <!-- FAQ Item 3 -->
            <details class="group bg-white rounded-2xl shadow-sm border border-slate-100 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-slate-900">
                    <h2 class="font-semibold text-lg">Bagaimana cara mengubah profil dan nama samaran saya?</h2>
                    <span class="relative h-5 w-5 shrink-0">
                        <svg class="absolute inset-0 opacity-100 group-open:opacity-0 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg class="absolute inset-0 opacity-0 group-open:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                    Anda dapat pergi ke halaman <a href="/settings" class="text-teal-600 hover:underline">Settings</a>. Di sana Anda dapat memperbarui Nama Asli, Nama Samaran, serta Kata Sandi Anda.
                </div>
            </details>

            <!-- FAQ Item 4 -->
            <details class="group bg-white rounded-2xl shadow-sm border border-slate-100 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-slate-900">
                    <h2 class="font-semibold text-lg">Apakah konseling di MindFlow berbayar?</h2>
                    <span class="relative h-5 w-5 shrink-0">
                        <svg class="absolute inset-0 opacity-100 group-open:opacity-0 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg class="absolute inset-0 opacity-0 group-open:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6 text-slate-600 leading-relaxed">
                    Kami menyediakan layanan dasar gratis (seperti Jurnal dan Tracker Suasana Hati). Namun untuk konseling secara profesional, kami menerapkan biaya konsultasi yang transparan sesuai dengan tarif masing-masing konselor.
                </div>
            </details>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-8 border-t border-slate-800 text-center">
        <div class="text-sm text-slate-500">
            &copy; {{ date('Y') }} MindFlow App. All rights reserved.
        </div>
    </footer>
</body>
</html>
