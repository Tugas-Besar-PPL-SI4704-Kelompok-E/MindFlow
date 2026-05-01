<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings - MindFlow</title>
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
                    <a href="{{ route('faq') }}" class="text-slate-600 hover:text-teal-600 font-medium transition">FAQ</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-5 py-2.5 rounded-full font-medium transition border border-rose-200">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto min-h-screen">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Account Settings</h1>
            <p class="text-slate-600 mt-2">Update your personal information and password here.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-teal-50 border border-teal-200 text-teal-800 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="glass-card rounded-3xl p-8 shadow-sm">
            <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Nama Asli -->
                <div>
                    <label for="nama_asli" class="block text-sm font-medium text-slate-700 mb-2">Nama Asli</label>
                    <input type="text" name="nama_asli" id="nama_asli" value="{{ old('nama_asli', $user->nama_asli) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-white" required>
                    @error('nama_asli')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Samaran -->
                <div>
                    <label for="nama_samaran" class="block text-sm font-medium text-slate-700 mb-2">Nama Samaran (Pseudonym)</label>
                    <input type="text" name="nama_samaran" id="nama_samaran" value="{{ old('nama_samaran', $user->nama_samaran) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-white" required>
                    @error('nama_samaran')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-slate-100 my-8">

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-slate-900">Change Password</h2>
                    <p class="text-sm text-slate-500 mt-1">Leave blank if you don't want to change it.</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-white">
                    @error('password')
                        <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-white">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-3 rounded-xl transition shadow-lg shadow-teal-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
