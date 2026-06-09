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

        @php
            $recommendations = [];

            // Evaluasi Depresi
            $katDepresi = strtolower($hasil->kategori_depresi);
            if (str_contains($katDepresi, 'sedang') || str_contains($katDepresi, 'berat') || str_contains($katDepresi, 'parah')) {
                $recommendations[] = [
                    'title' => 'Lawan Depresi dengan Langkah Kecil',
                    'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                    'color' => 'blue',
                    'tips' => [
                        'Mulailah hari dengan mencapai satu tujuan kecil (misal: merapikan tempat tidur).',
                        'Sempatkan waktu berjemur di bawah sinar matahari pagi minimal 15 menit.',
                        'Cobalah menuliskan 1 hal yang kamu syukuri setiap hari di buku jurnal.'
                    ]
                ];
            }

            // Evaluasi Kecemasan
            $katKecemasan = strtolower($hasil->kategori_kecemasan);
            if (str_contains($katKecemasan, 'sedang') || str_contains($katKecemasan, 'berat') || str_contains($katKecemasan, 'parah')) {
                $recommendations[] = [
                    'title' => 'Redakan Kecemasan & Tetap Grounded',
                    'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>',
                    'color' => 'indigo',
                    'tips' => [
                        'Praktikkan teknik grounding 5-4-3-2-1 saat merasa panik atau cemas.',
                        'Tarik napas dalam 4 detik, tahan 7 detik, dan hembuskan perlahan 8 detik.',
                        'Batasi konsumsi kafein dan hindari membuka media sosial sebelum tidur.'
                    ]
                ];
            }

            // Evaluasi Stres
            $katStres = strtolower($hasil->kategori_stres);
            if (str_contains($katStres, 'sedang') || str_contains($katStres, 'berat') || str_contains($katStres, 'parah')) {
                $recommendations[] = [
                    'title' => 'Manajemen Stres & Beban Pikiran',
                    'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>',
                    'color' => 'rose',
                    'tips' => [
                        'Pecah tugas besar menjadi beberapa bagian kecil yang mudah diselesaikan.',
                        'Lakukan aktivitas fisik ringan atau peregangan setiap 2 jam bekerja.',
                        'Belajarlah untuk berkata "tidak" pada komitmen tambahan jika bebanmu sudah penuh.'
                    ]
                ];
            }

            // Jika semua kategori Normal/Ringan
            if (empty($recommendations)) {
                $recommendations[] = [
                    'title' => 'Pertahankan Kondisi Positifmu',
                    'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    'color' => 'emerald',
                    'tips' => [
                        'Pertahankan pola tidur yang cukup (7-8 jam semalam).',
                        'Tetap terhubung dengan teman, keluarga, dan orang-orang yang kamu hargai.',
                        'Lanjutkan hobi dan aktivitas yang membuatmu bahagia.'
                    ]
                ];
            }
        @endphp

        <!-- Rekomendasi & Saran Personal Section -->
        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 24px; padding: 32px; text-align: left; margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                <div style="background: #FFFBEB; color: #D97706; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; color: #1E293B;">Rekomendasi & Saran Personal</h3>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($recommendations as $rec)
                <div style="background: #FFFFFF; border-radius: 16px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border-left: 4px solid var(--{{ $rec['color'] }}-500, #A881C2);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="color: var(--{{ $rec['color'] }}-600, #8A64A4);">
                            {!! $rec['icon'] !!}
                        </span>
                        <h4 style="font-weight: 700; color: #334155; font-size: 16px;">{{ $rec['title'] }}</h4>
                    </div>
                    <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 14px; line-height: 1.6;">
                        @foreach($rec['tips'] as $tip)
                        <li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#A881C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>{{ $tip }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
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