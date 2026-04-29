@extends('layouts.public')

@section('title', 'Masuk - MindFlow')

@section('styles')
<style>
    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        background: var(--gray-50);
    }

    /* ===== LEFT PANEL (Branding) ===== */
    .auth-brand {
        flex: 1;
        background: linear-gradient(135deg, var(--primary-900) 0%, var(--primary-700) 40%, var(--primary-500) 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }
    .auth-brand::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -20%;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(165,180,252,0.15) 0%, transparent 70%);
    }
    .auth-brand::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -10%;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(129,140,248,0.1) 0%, transparent 70%);
    }
    .auth-brand-content {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 400px;
    }
    .auth-brand-logo {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    .auth-brand-logo-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .auth-brand h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    .auth-brand p {
        font-size: 1rem;
        color: rgba(255,255,255,0.7);
        line-height: 1.7;
    }
    .auth-brand-features {
        list-style: none;
        margin-top: 2rem;
        text-align: left;
    }
    .auth-brand-features li {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .auth-brand-features li span {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    /* ===== RIGHT PANEL (Form) ===== */
    .auth-form-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .auth-form-container {
        width: 100%;
        max-width: 420px;
    }
    .auth-form-header {
        margin-bottom: 2rem;
    }
    .auth-form-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }
    .auth-form-header p {
        font-size: 0.95rem;
        color: var(--gray-500);
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.4rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--gray-200);
        border-radius: 10px;
        font-size: 0.95rem;
        color: var(--gray-800);
        background: white;
        transition: all 0.2s;
        outline: none;
    }
    .form-input:focus {
        border-color: var(--primary-400);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .form-input.is-invalid {
        border-color: var(--danger);
    }
    .form-error {
        font-size: 0.8rem;
        color: var(--danger);
        margin-top: 0.3rem;
    }
    .form-input-wrapper {
        position: relative;
    }
    .form-input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 1.1rem;
        pointer-events: none;
    }
    .form-input.with-icon {
        padding-left: 2.75rem;
    }

    .form-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--gray-600);
        cursor: pointer;
    }
    .form-checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--primary-600);
        cursor: pointer;
    }
    .form-link {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-600);
        transition: color 0.2s;
    }
    .form-link:hover {
        color: var(--primary-700);
    }

    .btn-submit {
        width: 100%;
        padding: 0.85rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(79,70,229,0.3);
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 25px rgba(79,70,229,0.4);
    }
    .btn-submit:active {
        transform: translateY(0);
    }

    .auth-divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }
    .auth-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--gray-200);
    }
    .auth-divider span {
        background: var(--gray-50);
        padding: 0 1rem;
        font-size: 0.8rem;
        color: var(--gray-400);
        position: relative;
    }

    .auth-alt-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: var(--gray-500);
    }
    .auth-alt-link a {
        font-weight: 600;
        color: var(--primary-600);
        transition: color 0.2s;
    }
    .auth-alt-link a:hover {
        color: var(--primary-700);
    }

    .back-home {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--gray-500);
        margin-bottom: 2rem;
        transition: color 0.2s;
    }
    .back-home:hover {
        color: var(--primary-600);
    }

    /* Alert for errors */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: start;
        gap: 0.5rem;
    }
    .alert-error-icon {
        color: var(--danger);
        font-size: 1.1rem;
        margin-top: 0.1rem;
    }
    .alert-error-text {
        font-size: 0.85rem;
        color: #991b1b;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .auth-brand { display: none; }
        .auth-form-panel { padding: 1.5rem; }
    }
</style>
@endsection

@section('body')
<div class="auth-wrapper">
    <!-- LEFT BRANDING PANEL -->
    <div class="auth-brand">
        <div class="auth-brand-content">
            <div class="auth-brand-logo">
                <div class="auth-brand-logo-icon">🧠</div>
                MindFlow
            </div>
            <h2>Selamat Datang Kembali!</h2>
            <p>Lanjutkan perjalanan kesehatan mental Anda. Kami senang melihat Anda kembali.</p>
            <ul class="auth-brand-features">
                <li><span>📊</span> Pantau mood dan kesehatan mental</li>
                <li><span>📝</span> Tulis jurnal refleksi pribadi</li>
                <li><span>💬</span> Konsultasi dengan konselor profesional</li>
                <li><span>🏛️</span> Bergabung dalam komunitas suportif</li>
            </ul>
        </div>
    </div>

    <!-- RIGHT FORM PANEL -->
    <div class="auth-form-panel">
        <div class="auth-form-container">
            <a href="/" class="back-home">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali ke Beranda
            </a>

            <div class="auth-form-header">
                <h1>Masuk</h1>
                <p>Masukkan email dan password Anda untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <div class="alert-error-icon">⚠️</div>
                    <div class="alert-error-text">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="form-input-wrapper">
                        <span class="form-input-icon">📧</span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input with-icon {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="form-input-wrapper">
                        <span class="form-input-icon">🔒</span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input with-icon"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>
                </div>

                <div class="form-row">
                    <label class="form-checkbox">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-submit" id="loginBtn">
                    Masuk
                </button>
            </form>

            <div class="auth-alt-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
