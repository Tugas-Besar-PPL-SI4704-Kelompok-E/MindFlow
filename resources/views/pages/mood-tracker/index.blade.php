@extends('layouts.dashboard')

@section('title', 'Mood Tracker - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px 80px;
        animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        text-align: center;
        margin-bottom: 50px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(168, 129, 194, 0.1);
        border: 1px solid rgba(168, 129, 194, 0.2);
        color: #A881C2;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 24px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .page-title {
        font-size: 36px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 16px;
        letter-spacing: -1px;
    }

    .page-desc {
        font-size: 16px;
        color: #6B7280;
        max-width: 550px;
        margin: 0 auto;
        line-height: 1.6;
        font-weight: 500;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 768px) {
        .cards-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .premium-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 32px;
        padding: 40px 32px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        position: relative;
        overflow: hidden;
    }

    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(168, 129, 194, 0.15);
        background: #FFFFFF;
        border-color: rgba(168, 129, 194, 0.3);
    }

    .card-icon {
        width: 64px;
        height: 64px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .premium-card:hover .card-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .icon-orange {
        background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%);
        color: #F97316;
        box-shadow: 0 8px 16px rgba(249, 115, 22, 0.15);
    }

    .icon-purple {
        background: linear-gradient(135deg, #F4EEFB 0%, #E9DDF5 100%);
        color: #A881C2;
        box-shadow: 0 8px 16px rgba(168, 129, 194, 0.15);
    }

    .premium-card h3 {
        font-size: 22px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .premium-card p {
        color: #6B7280;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 40px;
        flex-grow: 1;
        font-weight: 500;
    }

    .card-action {
        display: flex;
        align-items: center;
        font-weight: 800;
        font-size: 14px;
        color: #111827;
        transition: color 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .premium-card:hover .card-action {
        color: #A881C2;
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
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2000;
        background: rgba(17, 24, 39, 0.95);
        backdrop-filter: blur(10px);
        color: #FFFFFF;
        padding: 16px 24px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: toastIn 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                   toastOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) 3.6s forwards;
    }
    .toast-icon {
        width: 24px; height: 24px;
        background: #10B981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    @keyframes toastIn {
        from { opacity: 0; transform: translate(-50%, 40px); }
        to   { opacity: 1; transform: translate(-50%, 0); }
    }
    @keyframes toastOut {
        from { opacity: 1; transform: translate(-50%, 0); }
        to   { opacity: 0; transform: translate(-50%, 40px); }
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="header-section">
        <span class="badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            MindFlow Tracker
        </span>
        <h1 class="page-title">Kenali Perasaanmu Hari Ini</h1>
        <p class="page-desc">Pilih metode yang paling sesuai dengan kebutuhanmu. Luangkan waktu sejenak untuk terhubung kembali dengan dirimu sendiri.</p>
    </div>

    @if(session('feedback_tip'))
    <div style="background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%); border: 1px solid #FDBA74; border-radius: 24px; padding: 24px 32px; margin-bottom: 40px; display: flex; gap: 20px; align-items: flex-start; box-shadow: 0 10px 15px -3px rgba(234, 88, 12, 0.05);">
        <div style="background: #FFFFFF; padding: 12px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.1); color: #EA580C; flex-shrink: 0;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="6.5"></line></svg>
        </div>
        <div>
            <h3 style="font-size: 18px; font-weight: 800; color: #9A3412; margin-bottom: 8px;">Pertolongan Pertama</h3>
            <p style="color: #C2410C; font-size: 15px; line-height: 1.6; font-weight: 500;">{{ session('feedback_tip') }}</p>
        </div>
    </div>
    @endif

    <div class="cards-grid">
        <a href="{{ route('mood-tracker.singkat') }}" class="premium-card">
            <div class="card-icon icon-orange">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
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
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
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
