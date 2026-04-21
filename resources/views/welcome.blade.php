<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MindFlow - Nurture Your Mental Well-being</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #e0f2fe 0%, #ccfbf1 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass-card">
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
                    <a href="#features" class="text-slate-600 hover:text-teal-600 font-medium transition">Features</a>
                    <a href="#about" class="text-slate-600 hover:text-teal-600 font-medium transition">About</a>
                    <a href="#contact" class="text-slate-600 hover:text-teal-600 font-medium transition">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-slate-600 hover:text-teal-600 font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-teal-600 font-medium transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-teal-200">Sign up</a>
                            @endif
                        @endauth
                    @else
                        <a href="/login" class="text-slate-600 hover:text-teal-600 font-medium transition">Log in</a>
                        <a href="/register" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-teal-200">Sign up</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-gradient min-h-screen flex items-center">
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-teal-200/50 blur-3xl"></div>
            <div class="absolute top-1/2 right-0 w-96 h-96 rounded-full bg-sky-200/50 blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-100 text-teal-800 font-medium text-sm mb-6 border border-teal-200">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-teal-500"></span>
                        </span>
                        Your Journey to Peace Starts Here
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-6">
                        Find clarity and peace with <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-sky-600">MindFlow</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                        A safe space for your mental health. Track your mood, practice mindfulness, and connect with professionals—all in one beautifully designed platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/register" class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-4 rounded-full font-semibold transition shadow-xl shadow-teal-200/50 flex items-center justify-center gap-2 group">
                            Start for free
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#features" class="bg-white hover:bg-slate-50 text-slate-700 px-8 py-4 rounded-full font-semibold transition shadow-sm border border-slate-200 flex items-center justify-center">
                            Learn more
                        </a>
                    </div>
                </div>
                
                <!-- Hero Visual -->
                <div class="relative hidden lg:block">
                    <div class="relative w-full aspect-square max-w-lg mx-auto">
                        <!-- Abstract layered visual representing a peaceful mind -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-teal-400 to-sky-300 rounded-[3rem] rotate-6 opacity-80 mix-blend-multiply blur-sm"></div>
                        <div class="absolute inset-0 bg-white rounded-[3rem] shadow-2xl p-8 flex flex-col justify-between overflow-hidden">
                            <!-- Mock UI Elements -->
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="font-bold text-slate-800">Daily Check-in</h3>
                                    <p class="text-sm text-slate-500">How are you feeling today?</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-5 gap-3 mb-8">
                                <div class="aspect-square rounded-2xl bg-rose-100 flex items-center justify-center text-2xl hover:scale-110 transition cursor-pointer">😢</div>
                                <div class="aspect-square rounded-2xl bg-orange-100 flex items-center justify-center text-2xl hover:scale-110 transition cursor-pointer">😕</div>
                                <div class="aspect-square rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl hover:scale-110 transition cursor-pointer">😐</div>
                                <div class="aspect-square rounded-2xl bg-teal-100 flex items-center justify-center text-2xl hover:scale-110 transition cursor-pointer border-2 border-teal-500 scale-105 shadow-md">🙂</div>
                                <div class="aspect-square rounded-2xl bg-green-100 flex items-center justify-center text-2xl hover:scale-110 transition cursor-pointer">😄</div>
                            </div>
                            
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-sm">Guided Meditation</h4>
                                        <p class="text-xs text-slate-500">10 mins • Focus</p>
                                    </div>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-1.5">
                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-teal-600 font-semibold tracking-wide uppercase text-sm mb-3">Features</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6">Everything you need to nurture your mind</h3>
                <p class="text-lg text-slate-600">
                    MindFlow provides scientifically-backed tools to help you understand your emotions and build healthier mental habits.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 rounded-3xl p-8 hover:shadow-xl transition-all duration-300 border border-slate-100 hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Mood Tracking</h4>
                    <p class="text-slate-600">
                        Log your daily emotions to discover patterns and triggers. Visualize your mental health journey over time.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-50 rounded-3xl p-8 hover:shadow-xl transition-all duration-300 border border-slate-100 hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Mindfulness Exercises</h4>
                    <p class="text-slate-600">
                        Access a library of guided meditations, breathing exercises, and journaling prompts tailored for anxiety and stress.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-50 rounded-3xl p-8 hover:shadow-xl transition-all duration-300 border border-slate-100 hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Professional Support</h4>
                    <p class="text-slate-600">
                        Connect with licensed therapists and counselors directly through the platform when you need extra guidance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span class="font-bold text-2xl tracking-tight text-white">MindFlow</span>
                    </a>
                    <p class="text-sm text-slate-400 max-w-sm mb-6">
                        Your dedicated companion for mental wellness. Because taking care of your mind is just as important as taking care of your body.
                    </p>
                    <div class="text-sm text-slate-500">
                        &copy; {{ date('Y') }} MindFlow App. All rights reserved.
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-teal-400 transition">Features</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition">Mobile App</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-teal-400 transition">Blog</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-teal-400 transition">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
