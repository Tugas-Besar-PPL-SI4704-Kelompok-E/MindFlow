@extends('layouts.dashboard')

@section('title', 'Homepage - MindFlow')

@section('styles')
<style>
    .home-container {
        padding: 20px 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #A881C2 0%, #8A64A4 100%);
        border-radius: 32px;
        padding: 50px;
        color: white;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(168, 129, 194, 0.15);
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .welcome-stats {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 20px 25px;
        border-radius: 20px;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-info .value {
        font-size: 20px;
        font-weight: 700;
    }

    .stat-info .label {
        font-size: 12px;
        opacity: 0.8;
    }

    /* Section Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        gap: 30px;
    }

    .section-card {
        background: white;
        border-radius: 32px;
        padding: 30px;
        border: 1px solid #F1F1F1;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1A1A1A;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Mood Tracker Card Specifics */
    .mood-summary-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: #FAFAFA;
        padding: 24px;
        border-radius: 28px;
        border: 1px solid #F1F1F1;
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        background: #FFFFFF;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        border-color: #A881C2/20;
    }

    .mood-today-card {
        background: #FAFAFA;
        padding: 24px;
        border-radius: 28px;
        margin-bottom: 25px;
        border: 1px solid #F1F1F1;
    }

    .weekly-chart-card {
        background: #FAFAFA;
        padding: 24px;
        border-radius: 28px;
        border: 1px solid #F1F1F1;
    }

    /* Empty States */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100%;
        min-height: 300px;
        padding: 40px 20px;
    }

    .empty-illustration {
        width: 150px;
        height: 150px;
        margin-bottom: 20px;
        opacity: 0.6;
    }

    .empty-text {
        font-size: 13px;
        color: #8E8E93;
        line-height: 1.6;
    }

    .btn-link {
        color: #A881C2;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .home-container {
        animation: fadeIn 0.6s ease-out;
    }
</style>
@endsection

@section('content')
<div class="home-container">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div style="z-index: 1; position: relative;">
            <p style="font-size: 14px; opacity: 0.9; margin-bottom: 8px;">Selamat pagi,</p>
            <h1 style="font-size: 32px; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                {{ Auth::user()->nama_asli ?? 'User' }}
                <button style="background: none; border: none; padding: 0; cursor: pointer; color: white; opacity: 0.6; display: flex; align-items: center; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.6">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                </button>
            </h1>
            <p style="font-size: 14px; opacity: 0.9; margin-top: 10px;">Semoga harimu dipenuhi akan senyuman!</p>
        </div>

        <div class="welcome-stats" style="z-index: 1; position: relative;">
            @php
                $userId = Auth::id();
                $moodLogsCount = \App\Models\HasilCheckInstan::where('user_id', $userId)->count();
                $journalCount = \App\Models\Journal::where('user_id', $userId)->count();
                $avgMood = \App\Models\HasilCheckInstan::where('user_id', $userId)->avg('poin_skor') ?? 0;
            @endphp
            <div class="stat-box">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21a9 9 0 100-18 9 9 0 000 18z"/><path d="M8 10h.01M16 10h.01"/><path d="M14.8 15a3.5 3.5 0 01-5.6 0"/></svg>
                </div>
                <div class="stat-info">
                    <div class="value">{{ $moodLogsCount }} <span style="font-size: 12px; font-weight: 400; opacity: 0.7;">total</span></div>
                    <div class="label">Mood Logs</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                </div>
                <div class="stat-info">
                    <div class="value">{{ $journalCount }} <span style="font-size: 12px; font-weight: 400; opacity: 0.7;">total</span></div>
                    <div class="label">Journal</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/></svg>
                </div>
                <div class="stat-info">
                    <div class="value">{{ number_format($avgMood, 0) }}/10</div>
                    <div class="label">Rata-Rata Mood</div>
                </div>
            </div>
            <div style="flex: 1; display: flex; align-items: center; justify-content: flex-end;">
                <a href="{{ route('mood-tracker.index') }}" style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Mood Tracker Section -->
        <div class="section-card">
            <h3 class="card-title">Mood Tracker</h3>
            
            <div class="mood-summary-grid">
                <div class="summary-card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <div style="width: 32px; height: 32px; background: #E8F5E9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4CAF50;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                        </div>
                        <span style="font-size: 24px; font-weight: 800;">{{ number_format($avgMood, 0) }} <span style="font-size: 14px; font-weight: 600; color: #8E8E93;">/ 10</span></span>
                        <span style="color: #4CAF50; font-size: 12px; font-weight: 700; margin-left: auto;">▲ 0.3</span>
                    </div>
                    <p style="font-size: 12px; color: #8E8E93; font-weight: 500;">Rata-rata minggu ini</p>
                </div>
                <div class="summary-card">
                    @php
                        $bestMood = \App\Models\HasilCheckInstan::where('user_id', $userId)->orderBy('poin_skor', 'desc')->first();
                    @endphp
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        @php
                            $bestMoodColor = '#FBC02D'; // Default yellow
                            $bestMoodBg = '#FFF9C4';
                            if ($bestMood) {
                                if ($bestMood->poin_skor <= 4) {
                                    $bestMoodColor = '#FF4D4F'; // Red
                                    $bestMoodBg = '#FFEBEE';
                                } elseif ($bestMood->poin_skor <= 6) {
                                    $bestMoodColor = '#FFC107'; // Yellow/Orange
                                    $bestMoodBg = '#FFF8E1';
                                } else {
                                    $bestMoodColor = '#52C41A'; // Green
                                    $bestMoodBg = '#F6FFED';
                                }
                            }
                        @endphp
                        <div style="width: 32px; height: 32px; background: {{ $bestMoodBg }}; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: {{ $bestMoodColor }};">
                            @if($bestMood)
                                @if($bestMood->poin_skor <= 4)
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                @elseif($bestMood->poin_skor <= 6)
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="15" x2="16" y2="15"></line><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                @endif
                            @else
                                -
                            @endif
                        </div>
                        <span style="font-size: 20px; font-weight: 800;">{{ $bestMood->kategori_hasil ?? '-' }}</span>
                        <span style="color: #4CAF50; font-size: 12px; font-weight: 700; margin-left: auto;">▲</span>
                    </div>
                    <p style="font-size: 12px; color: #8E8E93; font-weight: 500;">Mood terbaik</p>
                </div>
            </div>

            <div class="mood-today-card">
                <p style="font-size: 11px; font-weight: 800; color: #8E8E93; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Mood Hari Ini</p>
                @php
                    $todayMood = \App\Models\HasilCheckInstan::where('user_id', $userId)->whereDate('created_at', today())->first();
                @endphp
                @if($todayMood)
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 40px;">
                            @if($todayMood->poin_skor <= 4)
                                &#128546;
                            @elseif($todayMood->poin_skor <= 6)
                                &#128528;
                            @else
                                &#128522;
                            @endif
                        </div>
                        <div>
                            <div style="font-size: 18px; font-weight: 800;">{{ $todayMood->kategori_hasil }} <span style="font-size: 14px; font-weight: 400; color: #8E8E93; margin-left: 10px;">{{ $todayMood->poin_skor }} / 10</span></div>
                            <p style="font-size: 13px; color: #8E8E93; margin-top: 5px;">
                                @if($todayMood->poin_skor <= 4)
                                    Jangan menyerah, hari esok pasti lebih baik! Cobalah bermeditasi.
                                @elseif($todayMood->poin_skor <= 6)
                                    Hari yang cukup tenang. Pertahankan pikiran positifmu!
                                @else
                                    Luar biasa! Bagikan energi positifmu kepada orang lain.
                                @endif
                            </p>
                            <p style="font-size: 11px; color: #C7C7CC; margin-top: 8px;">Dicatat pada {{ $todayMood->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 10px 0;">
                        <p style="font-size: 13px; color: #8E8E93;">Belum ada mood log hari ini.</p>
                        <a href="{{ route('mood-tracker.index') }}" class="btn-link" style="margin-top: 10px; display: inline-block;">Catat Mood Sekarang →</a>
                    </div>
                @endif
            </div>

            <div class="weekly-chart-card">
                @php
                    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $weeklyMoods = \App\Models\HasilCheckInstan::where('user_id', $userId)
                        ->where('created_at', '>=', now()->startOfWeek())
                        ->get()
                        ->groupBy(function($date) {
                            return \Carbon\Carbon::parse($date->created_at)->dayOfWeek;
                        });
                    $loggedDaysCount = $weeklyMoods->count();
                @endphp
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <p style="font-size: 11px; font-weight: 800; color: #8E8E93; text-transform: uppercase; letter-spacing: 1px;">Minggu Ini</p>
                    <p style="font-size: 11px; color: #C7C7CC; font-weight: 600;">{{ $loggedDaysCount }}/7 Hari</p>
                </div>
                <!-- Simple placeholder for the bar chart -->
                <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 100px; padding: 0 10px;">
                    @foreach([1, 2, 3, 4, 5, 6, 0] as $dayIndex)
                        @php
                            $dayMood = $weeklyMoods->get($dayIndex);
                            $avgScore = $dayMood ? $dayMood->avg('poin_skor') : 0;
                            $height = ($avgScore / 10) * 80;
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; flex: 1;">
                            @if($avgScore > 0)
                                <div style="width: 20px; height: 20px; margin-bottom: -5px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                    @if($avgScore <= 4)
                                        &#128546;
                                    @elseif($avgScore <= 6)
                                        &#128528;
                                    @else
                                        &#128522;
                                    @endif
                                </div>
                                <div style="width: 35px; height: {{ max($height, 15) }}px; background: #90EE90; border-radius: 10px; transition: all 0.3s;"></div>
                            @else
                                <div style="width: 35px; height: 15px; background: #EAEAEA; border-radius: 10px;"></div>
                            @endif
                            <span style="font-size: 10px; color: #C7C7CC; font-weight: 600;">{{ substr($days[$dayIndex], 0, 3) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Journal History Section -->
        <div class="section-card">
            <h3 class="card-title">Riwayat Jurnal</h3>
            @php
                $latestJournals = \App\Models\Journal::where('user_id', $userId)->latest()->take(3)->get();
            @endphp
            @if($latestJournals->isNotEmpty())
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($latestJournals as $journal)
                        <div style="padding: 20px; background: #FAFAFA; border-radius: 24px; border: 1px solid #F1F1F1; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#FFFFFF'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.02)';" onmouseout="this.style.backgroundColor='#FAFAFA'; this.style.boxShadow='none';">
                            <p style="font-size: 11px; color: #A881C2; font-weight: 800; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $journal->created_at->translatedFormat('d M Y') }}</p>
                            <p style="font-size: 14px; color: #4B5563; line-height: 1.6; font-weight: 500;">{{ Str::limit($journal->content, 85) }}</p>
                        </div>
                    @endforeach
                    <a href="{{ route('journals.index') }}" class="btn-link" style="text-align: center; margin-top: 5px; font-weight: 700; color: #A881C2;">Lihat Semua Jurnal →</a>
                </div>
            @else
                <div class="empty-state">
                    <div class="illustration-wrapper" style="margin-bottom: 30px;">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M95 85C103.284 85 110 78.2843 110 70C110 61.7157 103.284 55 95 55C94.469 55 93.9515 55.0276 93.4441 55.0815C89.9443 43.4357 79.1678 35 66.4286 35C53.6893 35 42.9128 43.4357 39.413 55.0815C38.9056 55.0276 38.3881 55 37.8571 55C29.5729 55 22.8571 61.7157 22.8571 70C22.8571 78.2843 29.5729 85 37.8571 85H95Z" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M75 95C81.6274 95 87 89.6274 87 83C87 76.3726 81.6274 71 75 71C74.5752 71 74.1612 71.0221 73.7553 71.0652C70.9554 61.7486 62.3342 55 52.1429 55C41.9515 55 33.3303 61.7486 30.5304 71.0652C30.1245 71.0221 29.7105 71 29.2857 71C22.6583 71 17.2857 76.3726 17.2857 83C17.2857 89.6274 22.6583 95 29.2857 95H75Z" stroke="#F1F1F1" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="empty-text">Jurnal masih kosong</p>
                    <a href="{{ route('journals.create') }}" class="btn-link" style="margin-top: 20px;">Tulis Jurnal →</a>
                </div>
            @endif
        </div>

        <!-- Consultation Session Section -->
        <div class="section-card">
            <div class="card-title">
                <span>Sesi Konsultasi</span>
                <a href="{{ route('konseling.index') }}" class="btn-link" style="font-size: 12px; color: #8E8E93;">Atur →</a>
            </div>
            @php
                $upcomingSessions = \App\Models\SesiKonseling::with('profilKonselor')
                    ->where('user_id', $userId)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('jadwal', 'asc')
                    ->get()
                    ->filter(function($session) {
                        // More robust date comparison for inconsistent database formats
                        try {
                            $sessionDate = \Carbon\Carbon::parse($session->jadwal);
                            return $sessionDate->isAfter(now()->startOfDay());
                        } catch (\Exception $e) {
                            return false;
                        }
                    })
                    ->take(2);
            @endphp
            @if($upcomingSessions->isNotEmpty())
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($upcomingSessions as $session)
                        <div style="padding: 20px; background: #FAFAFA; border-radius: 24px; border: 1px solid #F1F1F1; display: flex; align-items: center; gap: 15px; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#FFFFFF'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.02)';" onmouseout="this.style.backgroundColor='#FAFAFA'; this.style.boxShadow='none';">
                            <div style="width: 48px; height: 48px; border-radius: 16px; background: #F4EEFB; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #A881C2/10;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($session->profilKonselor->nama) }}&background=A881C2&color=fff&bold=true&size=48" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="flex: 1;">
                                <p style="font-size: 14px; font-weight: 700; color: #1A1A1A; margin-bottom: 2px;">{{ $session->profilKonselor->nama }}</p>
                                <p style="font-size: 12px; color: #8E8E93; font-weight: 600;">{{ \Carbon\Carbon::parse($session->jadwal)->translatedFormat('d M, H:i') }}</p>
                            </div>
                            <div style="padding: 5px 10px; background: #F4EEFB; color: #A881C2; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $session->status }}
                            </div>
                        </div>
                    @endforeach
                    <a href="{{ route('konseling.index') }}" class="btn-link" style="text-align: center; margin-top: 5px; font-weight: 700; color: #A881C2;">Lihat Semua Jadwal →</a>
                </div>
            @else
                <div class="empty-state">
                    <div class="illustration-wrapper" style="margin-bottom: 30px;">
                        <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="25" y="30" width="90" height="60" rx="4" stroke="#E5E7EB" stroke-width="3"/>
                            <line x1="70" y1="90" x2="70" y2="110" stroke="#E5E7EB" stroke-width="3"/>
                            <line x1="50" y1="110" x2="90" y2="110" stroke="#E5E7EB" stroke-width="3"/>
                            <path d="M100 80C100 80 105 75 108 85C111 95 105 115 105 115L115 115L118 90C118 90 125 90 125 105" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round"/>
                            <circle cx="110" cy="70" r="8" stroke="#E5E7EB" stroke-width="3"/>
                        </svg>
                    </div>
                    <p class="empty-text">Tidak ada jadwal ditemukan.<br>Ketuk untuk menambahkan jadwal</p>
                    <a href="{{ route('konseling.index') }}" class="btn-link" style="margin-top: 20px;">Cari Konselor →</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
