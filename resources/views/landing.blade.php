@extends('layouts.public')

@section('title', 'MindFlow - Jaga Kesehatan Mental Anda')

@section('styles')
<style>
    /* ===== NAVBAR ===== */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 1rem 2rem;
        transition: all 0.3s ease;
        background: transparent;
    }
    .navbar.scrolled {
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(20px);
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    .navbar-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .navbar-logo {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .navbar.scrolled .navbar-logo { color: var(--primary-700); }
    .navbar-logo-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary-400), var(--primary-600));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }
    .navbar.scrolled .navbar-logo-icon {
        background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
    }
    .navbar-links {
        display: flex;
        align-items: center;
        gap: 2rem;
        list-style: none;
    }
    .navbar-links a {
        font-size: 0.9rem;
        font-weight: 500;
        color: rgba(255,255,255,0.85);
        transition: color 0.2s;
    }
    .navbar.scrolled .navbar-links a { color: var(--gray-600); }
    .navbar-links a:hover { color: white; }
    .navbar.scrolled .navbar-links a:hover { color: var(--primary-600); }
    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .btn-login {
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
        border: 1.5px solid rgba(255,255,255,0.35);
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
    }
    .navbar.scrolled .btn-login {
        color: var(--primary-600);
        border-color: var(--primary-200);
    }
    .btn-login:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.6);
    }
    .navbar.scrolled .btn-login:hover {
        background: var(--primary-50);
        border-color: var(--primary-300);
    }
    .btn-signup {
        padding: 0.55rem 1.5rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-700);
        background: white;
        border: none;
        cursor: pointer;
        transition: all 0.25s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .navbar.scrolled .btn-signup {
        background: var(--primary-600);
        color: white;
    }
    .btn-signup:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .navbar.scrolled .btn-signup:hover {
        background: var(--primary-700);
    }

    /* ===== HERO ===== */
    .hero {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary-900) 0%, var(--primary-700) 40%, var(--primary-500) 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8rem 2rem 4rem;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 800px;
        height: 800px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(165,180,252,0.2) 0%, transparent 70%);
        animation: float 8s ease-in-out infinite;
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(129,140,248,0.15) 0%, transparent 70%);
        animation: float 10s ease-in-out infinite reverse;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-30px) scale(1.05); }
    }
    .hero-content {
        text-align: center;
        position: relative;
        z-index: 1;
        max-width: 800px;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.9);
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        animation: fadeInDown 0.8s ease;
    }
    .hero-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #34d399;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.3); }
    }
    .hero h1 {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 800;
        color: white;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s ease 0.1s both;
    }
    .hero h1 span {
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero p {
        font-size: 1.15rem;
        color: rgba(255,255,255,0.75);
        max-width: 560px;
        margin: 0 auto 2.5rem;
        line-height: 1.7;
        animation: fadeInUp 0.8s ease 0.2s both;
    }
    .hero-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        animation: fadeInUp 0.8s ease 0.3s both;
    }
    .btn-hero-primary {
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-700);
        background: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }
    .btn-hero-secondary {
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        color: white;
        background: rgba(255,255,255,0.1);
        border: 1.5px solid rgba(255,255,255,0.25);
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-hero-secondary:hover {
        background: rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.4);
    }
    .btn-hero-accent {
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        color: white;
        background: #10b981;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-hero-accent:hover {
        transform: translateY(-2px);
        background: #059669;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .hero-stats {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 3rem;
        margin-top: 4rem;
        animation: fadeInUp 0.8s ease 0.5s both;
    }
    .hero-stat {
        text-align: center;
    }
    .hero-stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: white;
    }
    .hero-stat-label {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.6);
        margin-top: 0.25rem;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== FEATURES ===== */
    .features {
        padding: 6rem 2rem;
        background: var(--gray-50);
    }
    .features-inner {
        max-width: 1100px;
        margin: 0 auto;
    }
    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }
    .section-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--primary-600);
        margin-bottom: 0.75rem;
    }
    .section-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--gray-900);
        letter-spacing: -0.02em;
        margin-bottom: 1rem;
    }
    .section-desc {
        font-size: 1.05rem;
        color: var(--gray-500);
        max-width: 550px;
        margin: 0 auto;
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .feature-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--gray-100);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-400), var(--primary-600));
        transform: scaleX(0);
        transition: transform 0.3s;
    }
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(79,70,229,0.1);
        border-color: var(--primary-100);
    }
    .feature-card:hover::before { transform: scaleX(1); }
    .feature-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        font-size: 1.5rem;
    }
    .feature-icon.purple { background: var(--primary-100); color: var(--primary-600); }
    .feature-icon.green { background: #d1fae5; color: #059669; }
    .feature-icon.blue { background: #dbeafe; color: #2563eb; }
    .feature-icon.orange { background: #ffedd5; color: #ea580c; }
    .feature-icon.pink { background: #fce7f3; color: #db2777; }
    .feature-icon.teal { background: #ccfbf1; color: #0d9488; }
    .feature-card h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }
    .feature-card p {
        font-size: 0.9rem;
        color: var(--gray-500);
        line-height: 1.6;
    }

    /* ===== HOW IT WORKS ===== */
    .how-it-works {
        padding: 6rem 2rem;
        background: white;
    }
    .how-it-works-inner {
        max-width: 900px;
        margin: 0 auto;
    }
    .steps {
        display: flex;
        flex-direction: column;
        gap: 0;
        position: relative;
    }
    .step {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        position: relative;
        padding-bottom: 3rem;
    }
    .step:last-child { padding-bottom: 0; }
    .step-number {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }
    .step:not(:last-child) .step-number::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: calc(100% + 2rem);
        background: var(--primary-200);
        z-index: 1;
    }
    .step-content h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
        margin-top: 0.5rem;
    }
    .step-content p {
        font-size: 0.95rem;
        color: var(--gray-500);
        line-height: 1.7;
    }

    /* ===== ROLES / CTA ===== */
    .roles-section {
        padding: 6rem 2rem;
        background: var(--gray-50);
    }
    .roles-inner {
        max-width: 1100px;
        margin: 0 auto;
    }
    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .role-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem 2rem;
        text-align: center;
        border: 1px solid var(--gray-200);
        transition: all 0.3s;
        position: relative;
    }
    .role-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .role-card.featured {
        border-color: var(--primary-300);
        box-shadow: 0 4px 20px rgba(79,70,229,0.12);
    }
    .role-card.featured::before {
        content: 'Populer';
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.25rem 1rem;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .role-emoji {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .role-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.75rem;
    }
    .role-card p {
        font-size: 0.9rem;
        color: var(--gray-500);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    .role-features {
        list-style: none;
        text-align: left;
        margin-bottom: 2rem;
    }
    .role-features li {
        font-size: 0.85rem;
        color: var(--gray-600);
        padding: 0.4rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .role-features li::before {
        content: '✓';
        color: var(--primary-500);
        font-weight: 700;
        font-size: 0.9rem;
    }
    .btn-role {
        display: inline-block;
        padding: 0.7rem 2rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
        width: 100%;
    }
    .btn-role-primary {
        background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        color: white;
        box-shadow: 0 4px 15px rgba(79,70,229,0.3);
    }
    .btn-role-primary:hover {
        box-shadow: 0 6px 25px rgba(79,70,229,0.4);
        transform: translateY(-1px);
    }
    .btn-role-outline {
        background: transparent;
        color: var(--primary-600);
        border: 1.5px solid var(--primary-200);
    }
    .btn-role-outline:hover {
        background: var(--primary-50);
        border-color: var(--primary-300);
    }

    /* ===== CTA ===== */
    .cta-section {
        padding: 6rem 2rem;
        background: linear-gradient(135deg, var(--primary-800) 0%, var(--primary-600) 100%);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .cta-inner {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    .cta-section h2 {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        color: white;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    .cta-section p {
        font-size: 1.05rem;
        color: rgba(255,255,255,0.7);
        margin-bottom: 2rem;
        line-height: 1.7;
    }
    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.9rem 2.5rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-700);
        background: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    /* ===== FOOTER ===== */
    .footer {
        background: var(--gray-900);
        color: var(--gray-400);
        padding: 3rem 2rem;
    }
    .footer-inner {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .footer-logo {
        font-size: 1.25rem;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .footer p {
        font-size: 0.85rem;
    }
    .footer-links {
        display: flex;
        gap: 1.5rem;
        list-style: none;
    }
    .footer-links a {
        font-size: 0.85rem;
        color: var(--gray-400);
        transition: color 0.2s;
    }
    .footer-links a:hover { color: white; }

    /* ===== MOBILE HAMBURGER ===== */
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
    }
    .mobile-menu-btn span {
        display: block;
        width: 22px;
        height: 2px;
        background: white;
        margin: 5px 0;
        border-radius: 2px;
        transition: all 0.3s;
    }
    .navbar.scrolled .mobile-menu-btn span { background: var(--gray-700); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .navbar-links { display: none; }
        .mobile-menu-btn { display: block; }
        .hero { padding: 7rem 1.5rem 3rem; }
        .hero h1 { font-size: 2.2rem; }
        .hero p { font-size: 1rem; }
        .hero-actions { flex-direction: column; }
        .hero-stats { gap: 1.5rem; }
        .hero-stat-number { font-size: 1.5rem; }
        .features, .how-it-works, .roles-section, .cta-section {
            padding: 4rem 1.5rem;
        }
        .features-grid, .roles-grid {
            grid-template-columns: 1fr;
        }
        .step { gap: 1rem; }
        .footer-inner {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('body')
    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="/" class="navbar-logo">
                <div class="navbar-logo-icon">🧠</div>
                MindFlow
            </a>
            <ul class="navbar-links">
                <li><a href="#features">Fitur</a></li>
                <li><a href="#how-it-works">Cara Kerja</a></li>
                <li><a href="#roles">Untuk Siapa</a></li>
            </ul>
            <div class="navbar-actions">
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                <a href="{{ route('register') }}" class="btn-signup">Daftar Gratis</a>
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Platform Kesehatan Mental #1 di Indonesia
            </div>
            <h1>Jaga Kesehatan <span>Mental</span> Anda Bersama MindFlow</h1>
            <p>Platform lengkap untuk memantau mood, menulis jurnal refleksi, berkonsultasi dengan konselor profesional, dan bergabung dalam komunitas yang mendukung.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-hero-primary">
                    Mulai Sekarang
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a href="{{ route('mood-tracker.mendalam') }}" class="btn-hero-accent">
                    🩺 Cek Kesehatan Mental Gratis
                </a>
                <a href="#features" class="btn-hero-secondary">
                    Pelajari Lebih Lanjut
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-number">1000+</div>
                    <div class="hero-stat-label">Pengguna Aktif</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">20+</div>
                    <div class="hero-stat-label">Konselor Profesional</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">100+</div>
                    <div class="hero-stat-label">Sesi Konseling</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features" id="features">
        <div class="features-inner">
            <div class="section-header">
                <div class="section-label">Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Anda Butuhkan</h2>
                <p class="section-desc">Fitur lengkap untuk membantu perjalanan kesehatan mental Anda setiap hari.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon purple">📊</div>
                    <h3>Mood Tracker</h3>
                    <p>Pantau kondisi emosional Anda setiap hari dan temukan pola yang membantu Anda memahami diri sendiri lebih baik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon green">📝</div>
                    <h3>Jurnal Refleksi</h3>
                    <p>Tulis jurnal harian untuk merefleksikan pikiran dan perasaan Anda secara pribadi dan aman.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon blue">💬</div>
                    <h3>Konseling Online</h3>
                    <p>Konsultasi langsung dengan konselor profesional yang berpengalaman melalui sesi online terjadwal.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon orange">🏛️</div>
                    <h3>Forum Komunitas</h3>
                    <p>Bergabung dengan komunitas yang saling mendukung, berbagi pengalaman, dan saling menguatkan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon pink">📚</div>
                    <h3>Artikel & Edukasi</h3>
                    <p>Akses artikel dan konten edukatif tentang kesehatan mental yang ditulis oleh para ahli.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon teal">🔒</div>
                    <h3>Privasi Terjamin</h3>
                    <p>Data Anda aman dan terlindungi. Gunakan nama samaran untuk menjaga privasi identitas Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-it-works" id="how-it-works">
        <div class="how-it-works-inner">
            <div class="section-header">
                <div class="section-label">Cara Kerja</div>
                <h2 class="section-title">Mulai dalam 3 Langkah</h2>
                <p class="section-desc">Proses sederhana untuk memulai perjalanan kesehatan mental Anda.</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Buat Akun Gratis</h3>
                        <p>Daftar dengan nama asli dan nama samaran. Nama samaran Anda akan digunakan di forum untuk menjaga privasi.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Jelajahi Fitur</h3>
                        <p>Mulai tulis jurnal refleksi, pantau mood harian, baca artikel edukatif, atau bergabung di forum komunitas.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Konsultasi dengan Konselor</h3>
                        <p>Jika membutuhkan bimbingan lebih lanjut, jadwalkan sesi konseling dengan konselor profesional kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ROLES -->
    <section class="roles-section" id="roles">
        <div class="roles-inner">
            <div class="section-header">
                <div class="section-label">Untuk Siapa?</div>
                <h2 class="section-title">MindFlow untuk Semua</h2>
                <p class="section-desc">Platform ini dirancang untuk berbagai peran demi ekosistem kesehatan mental yang menyeluruh.</p>
            </div>
            <div class="roles-grid">
                <div class="role-card featured">
                    <div class="role-emoji">👤</div>
                    <h3>Pengguna</h3>
                    <p>Untuk siapa saja yang ingin menjaga dan memantau kesehatan mental.</p>
                    <ul class="role-features">
                        <li>Tulis jurnal refleksi pribadi</li>
                        <li>Pantau mood harian</li>
                        <li>Akses forum & artikel</li>
                        <li>Jadwalkan sesi konseling</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-role btn-role-primary">Daftar Sekarang</a>
                </div>
                <div class="role-card">
                    <div class="role-emoji">🩺</div>
                    <h3>Konselor</h3>
                    <p>Untuk profesional yang ingin memberikan layanan konseling online.</p>
                    <ul class="role-features">
                        <li>Kelola jadwal konseling</li>
                        <li>Akses rekam medis klien</li>
                        <li>Buat catatan sesi</li>
                        <li>Daftar sebagai user terlebih dahulu</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-role btn-role-outline">Daftar & Apply</a>
                </div>
                <div class="role-card">
                    <div class="role-emoji">⚙️</div>
                    <h3>Admin</h3>
                    <p>Mengelola platform, moderasi konten, dan verifikasi konselor.</p>
                    <ul class="role-features">
                        <li>Moderasi forum & konten</li>
                        <li>Verifikasi calon konselor</li>
                        <li>Kelola pengguna platform</li>
                        <li>Dashboard analitik</li>
                    </ul>
                    <span class="btn-role btn-role-outline" style="opacity: 0.5; cursor: default;">Khusus Internal</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-inner">
            <h2>Mulai Perjalanan Anda Hari Ini</h2>
            <p>Bergabunglah dengan ribuan orang yang telah mempercayakan perjalanan kesehatan mental mereka bersama MindFlow.</p>
            <a href="{{ route('register') }}" class="btn-cta">
                Daftar Gratis Sekarang
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-logo">🧠 MindFlow</div>
            <p>&copy; {{ date('Y') }} MindFlow. All rights reserved.</p>
            <ul class="footer-links">
                <li><a href="#">Kebijakan Privasi</a></li>
                <li><a href="#">Syarat & Ketentuan</a></li>
                <li><a href="#">Bantuan</a></li>
            </ul>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
@endsection
