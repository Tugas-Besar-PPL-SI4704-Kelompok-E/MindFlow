@extends('layouts.dashboard', ['hideSidebar' => true])

@section('title', 'Hasil Pemeriksaan Mendalam - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 860px;
        margin: 0 auto;
        padding-bottom: 80px;
        animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .top-bar {
        margin-bottom: 32px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        color: #6B7280;
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        padding: 10px 20px;
        border-radius: 100px;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .btn-back:hover {
        background: #F9FAFB;
        color: #111827;
        border-color: #D1D5DB;
    }
    .btn-back svg {
        margin-right: 8px;
    }

    .result-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 32px;
        padding: 50px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
        text-align: center;
        margin-bottom: 30px;
    }

    .result-title {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }

    .result-subtitle {
        color: #6B7280;
        font-size: 15px;
        margin-bottom: 40px;
    }

    .scores-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .score-box {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        transition: transform 0.2s;
    }
    .score-box:hover {
        transform: translateY(-5px);
    }

    .score-title {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 15px;
    }

    .score-category {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .score-value {
        font-size: 13px;
        color: #9CA3AF;
    }

    /* Colors based on severity */
    .cat-normal { background: #DCFCE7; color: #059669; }
    .cat-ringan { background: #FEF9C3; color: #16A34A; }
    .cat-sedang { background: #FEF08A; color: #CA8A04; }
    .cat-parah { background: #FFEDD5; color: #D97706; }
    .cat-sangat-parah { background: #FEE2E2; color: #DC2626; }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-primary {
        background: #9B76D6;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-primary:hover {
        background: #8B66C6;
    }

    .btn-secondary {
        background: #FFFFFF;
        color: #4B5563;
        border: 1px solid #D1D5DB;
        padding: 14px 28px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #F9FAFB;
        color: #111827;
    }
    
    .disclaimer {
        font-size: 13px;
        color: #9CA3AF;
        margin-top: 30px;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="top-bar">
        <a href="{{ route('mood-tracker.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div style="background: #DCFCE7; color: #166534; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 12px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="result-card">
        <h2 class="result-title">Hasil Asesmen DASS-21</h2>
        <p class="result-subtitle">Berdasarkan jawabanmu, berikut adalah gambaran kondisi emosionalmu selama satu minggu terakhir.</p>

        @php
            function getCategoryClass($kategori) {
                $kat = strtolower($kategori);
                if (str_contains($kat, 'normal')) return 'cat-normal';
                if (str_contains($kat, 'ringan')) return 'cat-ringan';
                if (str_contains($kat, 'sedang')) return 'cat-sedang';
                if (str_contains($kat, 'sangat parah') || str_contains($kat, 'sangat berat')) return 'cat-sangat-parah';
                if (str_contains($kat, 'parah') || str_contains($kat, 'berat')) return 'cat-parah';
                return 'cat-normal';
            }
        @endphp

        <div class="scores-container">
            <!-- Depresi -->
            <div class="score-box">
                <div class="score-title">Tingkat Depresi</div>
                <div class="score-category {{ getCategoryClass($hasil->kategori_depresi) }}">
                    {{ ucfirst($hasil->kategori_depresi) }}
                </div>
                <div class="score-value">Skor: {{ $hasil->skor_depresi }}</div>
            </div>

            <!-- Kecemasan -->
            <div class="score-box">
                <div class="score-title">Tingkat Kecemasan</div>
                <div class="score-category {{ getCategoryClass($hasil->kategori_kecemasan) }}">
                    {{ ucfirst($hasil->kategori_kecemasan) }}
                </div>
                <div class="score-value">Skor: {{ $hasil->skor_kecemasan }}</div>
            </div>

            <!-- Stres -->
            <div class="score-box">
                <div class="score-title">Tingkat Stres</div>
                <div class="score-category {{ getCategoryClass($hasil->kategori_stres) }}">
                    {{ ucfirst($hasil->kategori_stres) }}
                </div>
                <div class="score-value">Skor: {{ $hasil->skor_stres }}</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('konseling.index') }}" class="btn-primary">Konsultasi dengan Ahli</a>
            <a href="{{ route('journals.index') }}" class="btn-secondary">Tulis Jurnal</a>
        </div>
        
        <div class="disclaimer">
            *Catatan: Hasil ini bukanlah diagnosis klinis pasti. Ini hanyalah alat bantu skrining awal. 
            Jika kamu merasa kesulitan atau butuh bantuan, sangat disarankan untuk berkonsultasi langsung dengan psikolog atau profesional kesehatan mental.
        </div>
    </div>
</div>
@endsection