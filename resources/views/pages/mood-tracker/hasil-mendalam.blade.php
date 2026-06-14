@extends('layouts.dashboard', ['hideSidebar' => true])

@section('title', 'Hasil Pemeriksaan Mendalam - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 800px;
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
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 32px;
        padding: 50px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
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
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.01);
    }
    .score-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(168, 129, 194, 0.08);
        border-color: rgba(168, 129, 194, 0.2);
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
        background: linear-gradient(135deg, #A881C2 0%, #8A64A4 100%);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 8px 15px rgba(168, 129, 194, 0.2);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #8A64A4 0%, #6E498A 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 20px rgba(168, 129, 194, 0.3);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        color: #4B5563;
        border: 1px solid rgba(209, 213, 219, 0.5);
        padding: 14px 28px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-secondary:hover {
        background: #FFFFFF;
        color: #111827;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
        border-color: #D1D5DB;
    }
    
    .disclaimer {
        font-size: 13px;
        color: #9CA3AF;
        margin-top: 30px;
        line-height: 1.5;
    }

    /* Elegant Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(17, 24, 39, 0.4);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease;
    }
    .modal-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
    .modal-box {
        background: #FFFFFF;
        width: 100%;
        max-width: 440px;
        padding: 48px 40px;
        border-radius: 32px;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95) translateY(20px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .modal-overlay.show .modal-box {
        transform: scale(1) translateY(0);
    }
    .modal-icon {
        font-size: 56px;
        margin-bottom: 24px;
        display: inline-block;
        background: #FEF2F2;
        width: 96px; height: 96px;
        border-radius: 50%;
        line-height: 96px;
    }
    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }
    .modal-text {
        color: #6B7280;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 40px;
    }
    .modal-actions {
        display: flex;
        gap: 16px;
    }
    .modal-btn-secondary {
        flex: 1;
        padding: 16px 20px;
        background: #F3F4F6;
        color: #374151;
        border-radius: 16px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .modal-btn-secondary:hover {
        background: #E5E7EB;
        color: #111827;
    }
    .modal-btn-primary {
        flex: 1;
        padding: 16px 20px;
        background: #111827;
        color: #FFFFFF;
        border-radius: 16px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .modal-btn-primary:hover {
        background: #1F2937;
        transform: translateY(-2px);
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
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                    'color' => '#3B82F6', // Blue-500
                    'bg' => '#EFF6FF', // Blue-50
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
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>',
                    'color' => '#8B5CF6', // Violet-500
                    'bg' => '#F5F3FF', // Violet-50
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
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>',
                    'color' => '#F43F5E', // Rose-500
                    'bg' => '#FFF1F2', // Rose-50
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
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    'color' => '#10B981', // Emerald-500
                    'bg' => '#ECFDF5', // Emerald-50
                    'tips' => [
                        'Pertahankan pola tidur yang cukup (7-8 jam semalam).',
                        'Tetap terhubung dengan teman, keluarga, dan orang-orang yang kamu hargai.',
                        'Lanjutkan hobi dan aktivitas yang membuatmu bahagia.'
                    ]
                ];
            }
        @endphp

        <!-- Rekomendasi & Saran Personal Section -->
        <div style="background: rgba(255, 255, 255, 0.5); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 24px; padding: 32px; text-align: left; margin-bottom: 40px; box-shadow: inset 0 2px 4px rgba(255,255,255,0.5);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                <div style="background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%); color: #D97706; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; color: #1E293B;">Rekomendasi & Saran Personal</h3>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($recommendations as $rec)
                <div style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-radius: 20px; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); border: 1px solid rgba(255,255,255,0.9); transition: transform 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.06)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.03)';">

                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                        <div style="background: {{ $rec['bg'] }}; color: {{ $rec['color'] }}; width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px {{ $rec['color'] }}20;">
                            {!! $rec['icon'] !!}
                        </div>
                        <h4 style="font-weight: 800; color: #1E293B; font-size: 17px;">{{ $rec['title'] }}</h4>
                    </div>
                    <ul style="list-style-type: none; padding: 0; margin: 0; color: #475569; font-size: 14.5px; line-height: 1.6; padding-left: 58px;">
                        @foreach($rec['tips'] as $tip)
                        <li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $rec['color'] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
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

    <!-- Modal Pop-up untuk Tawaran Jurnal -->
    @if(session('offer_journal'))
    <div class="modal-overlay show" id="journalOfferModal">
        <div class="modal-box">
            <div class="modal-icon">🫂</div>
            <h3 class="modal-title">Sepertinya harimu berat</h3>
            <p class="modal-text">Kami perhatikan kamu sedang merasa cukup tertekan saat ini. Maukah kamu menuangkan perasaanmu lewat tulisan jurnal agar bebanmu sedikit berkurang?</p>
            <div class="modal-actions">
                <button type="button" class="modal-btn-secondary" id="btnSkipJournalModal">Lewati</button>
                <a href="{{ route('journals.create') }}" class="modal-btn-primary">Tulis Jurnal</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('journalOfferModal');
        const btnSkip = document.getElementById('btnSkipJournalModal');

        if (btnSkip && modal) {
            btnSkip.addEventListener('click', function() {
                modal.classList.remove('show');
                // Hapus elemen dari DOM setelah animasi transisi selesai (0.4s)
                setTimeout(() => {
                    modal.remove();
                }, 400);
            });
        }
    });
</script>
@endsection