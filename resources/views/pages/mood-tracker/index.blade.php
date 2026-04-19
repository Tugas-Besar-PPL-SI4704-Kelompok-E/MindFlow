@extends('layouts.dashboard')

@section('title', 'Mood Tracker - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 960px;
        margin: 0 auto;
        padding: 20px 0 60px 0;
        animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        text-align: center;
        margin-bottom: 60px;
    }

    .badge {
        display: inline-block;
        background: #F3E8FF;
        color: #7E22CE;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
        letter-spacing: 0.5px;
    }

    .page-title {
        font-size: 38px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 16px;
        letter-spacing: -1.2px;
    }

    .page-desc {
        font-size: 17px;
        color: #6B7280;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .premium-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 28px;
        padding: 48px 40px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .premium-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
        border-color: #D1D5DB;
    }

    .card-icon {
        width: 72px;
        height: 72px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 36px;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .premium-card:hover .card-icon {
        transform: scale(1.05) rotate(-4deg);
    }

    .icon-orange {
        background: #FFF7ED;
        color: #EA580C;
    }

    .icon-purple {
        background: #F3E8FF;
        color: #7E22CE;
    }

    .premium-card h3 {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 14px;
        letter-spacing: -0.5px;
    }

    .premium-card p {
        color: #6B7280;
        font-size: 16px;
        line-height: 1.65;
        margin-bottom: 48px;
        flex-grow: 1;
    }

    .card-action {
        display: flex;
        align-items: center;
        font-weight: 600;
        font-size: 16px;
        color: #111827;
        transition: color 0.2s;
    }

    .premium-card:hover .card-action {
        color: var(--primary-purple);
    }

    .card-action svg {
        margin-left: 8px;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .premium-card:hover .card-action svg {
        transform: translateX(6px);
    }

    /* Toast notification */
    .toast {
        position: fixed;
        top: 32px;
        right: 32px;
        z-index: 2000;
        background: #111827;
        color: #FFFFFF;
        padding: 18px 28px;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 500;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: toastIn 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                   toastOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) 3.6s forwards;
    }
    .toast-icon {
        width: 28px; height: 28px;
        background: #059669;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    @keyframes toastIn {
        from { opacity: 0; transform: translateX(40px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes toastOut {
        from { opacity: 1; transform: translateX(0); }
        to   { opacity: 0; transform: translateX(40px); }
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="header-section">
        <span class="badge">MindFlow Tracker</span>
        <h1 class="page-title">Kenali Perasaanmu Hari Ini</h1>
        <p class="page-desc">Pilih metode yang paling sesuai dengan kebutuhanmu. Luangkan waktu sejenak untuk terhubung kembali dengan dirimu sendiri.</p>
    </div>

    <div class="cards-grid">
        <a href="{{ route('mood-tracker.singkat') }}" class="premium-card">
            <div class="card-icon icon-orange">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <h3>Pemeriksaan Singkat</h3>
            <p>Evaluasi cepat 1 menit. Sangat cocok untuk mencatat fluktuasi emosi harianmu secara instan tanpa menguras waktu dan tenaga.</p>
            <div class="card-action">
                Mulai Singkat
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </a>

        <a href="{{ route('mood-tracker.mendalam') }}" class="premium-card">
            <div class="card-icon icon-purple">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <circle cx="12" cy="11" r="3"/>
                </svg>
            </div>
            <h3>Pemeriksaan Mendalam</h3>
            <p>Asesmen DASS-21 yang komprehensif untuk memahami tingkat stres, depresi, dan kecemasanmu lebih dalam secara klinis.</p>
            <div class="card-action">
                Mulai Mendalam
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="toast" id="successToast">
        <div class="toast-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        {{ session('success') }}
    </div>
@endif
@endsection

@section('scripts')
<script>
    // Auto-remove toast after animation ends
    const toast = document.getElementById('successToast');
    if (toast) {
        setTimeout(() => toast.remove(), 4200);
    }
</script>
@endsection
