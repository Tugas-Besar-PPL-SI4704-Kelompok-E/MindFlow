@extends('layouts.dashboard')

@section('title', 'Homepage - MindFlow')

@section('styles')
<style>
    .home-container {
        padding: 0 20px;
        max-width: 1280px;
        margin: 0 auto;
        padding-bottom: 60px;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #A881C2 0%, #8A64A4 100%);
        border-radius: 32px;
        padding: 40px 50px;
        color: white;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(168, 129, 194, 0.2);
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -100px;
        right: -50px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .welcome-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 35px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        padding: 20px 24px;
        border-radius: 24px;
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease, background 0.3s ease;
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.2);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #FFFFFF;
        box-shadow: inset 0 2px 4px rgba(255,255,255,0.3);
    }

    .stat-info .value {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-info .label {
        font-size: 13px;
        font-weight: 600;
        opacity: 0.85;
        margin-top: 2px;
    }

    /* Section Components */
    .section-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 32px;
        padding: 32px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .section-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        background: rgba(255, 255, 255, 0.9);
    }

    .card-title {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 24px;
        color: #111827;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Sub Cards */
    .inner-card {
        background: #FFFFFF;
        padding: 24px;
        border-radius: 24px;
        border: 1px solid #F3F4F6;
        transition: all 0.3s ease;
    }

    .inner-card:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        border-color: rgba(168, 129, 194, 0.3);
    }

    /* Empty States */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px;
        flex: 1;
    }

    .empty-text {
        font-size: 14px;
        font-weight: 600;
        color: #9CA3AF;
        line-height: 1.6;
    }

    .btn-link {
        color: #A881C2;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        transition: color 0.2s;
    }
    
    .btn-link:hover {
        color: #8A64A4;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .home-container {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endsection

@section('content')
<div class="home-container">
    @php
        $unpaidSession = \App\Models\SesiKonseling::with('profilKonselor')
            ->where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->where('status', 'approved')
            ->first();
    @endphp

    @if($unpaidSession)
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-900 p-5 rounded-2xl mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-sm animate-in fade-in duration-500">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-md shadow-blue-200 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-blue-950">Sesi Disetujui! Menunggu Pembayaran</h4>
                    <p class="text-xs text-blue-800 font-medium mt-1">Sesi dengan <strong>{{ $unpaidSession->profilKonselor->nama }}</strong> pada {{ \Carbon\Carbon::parse($unpaidSession->jadwal)->translatedFormat('d F Y, H:i') }} telah disetujui. Silakan bayar dalam 24 jam.</p>
                </div>
            </div>
            <a href="{{ route('booking.checkout', $unpaidSession->sesi_konseling_id) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-300/30 transition-all active:scale-[0.98] shrink-0">
                Bayar Sekarang
            </a>
        </div>
    @endif

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
                $avgMoodAllTime = \App\Models\HasilCheckInstan::where('user_id', $userId)->avg('poin_skor') ?? 0;
                
                $thisWeekMoods = \App\Models\HasilCheckInstan::where('user_id', $userId)
                    ->where('created_at', '>=', now()->startOfWeek())
                    ->orderBy('created_at', 'asc')
                    ->get();
                
                $avgMoodWeekly = 0;
                $moodTrend = null;

                if ($thisWeekMoods->count() > 0) {
                    $avgMoodWeekly = $thisWeekMoods->avg('poin_skor');
                    
                    if ($thisWeekMoods->count() > 1) {
                        // Rata-rata minggu ini sebelum mood terakhir diinput
                        $previousAvg = $thisWeekMoods->take($thisWeekMoods->count() - 1)->avg('poin_skor');
                        $moodTrend = $avgMoodWeekly - $previousAvg;
                    }
                }
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
                    <div class="value">{{ number_format($avgMoodAllTime, 0) }}/10</div>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        <!-- Mood Tracker Section -->
        <div class="col-span-1 lg:col-span-5 section-card">
            <h3 class="card-title">
                Mood Tracker
                <a href="{{ route('mood-tracker.index') }}" class="btn-link text-xs">Catat →</a>
            </h3>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="inner-card flex flex-col justify-center">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <div style="width: 32px; height: 32px; background: #E8F5E9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4CAF50;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                        </div>
                        <span style="font-size: 24px; font-weight: 800;">{{ number_format($avgMoodWeekly, 0) }} <span style="font-size: 14px; font-weight: 600; color: #8E8E93;">/ 10</span></span>
                        @if($moodTrend !== null)
                            @php
                                $trendColor = '#8E8E93';
                                $trendIcon = '-';
                                if ($moodTrend > 0) {
                                    $trendColor = '#4CAF50';
                                    $trendIcon = '▲';
                                } elseif ($moodTrend < 0) {
                                    $trendColor = '#F44336';
                                    $trendIcon = '▼';
                                }
                            @endphp
                            <span style="color: {{ $trendColor }}; font-size: 12px; font-weight: 700; margin-left: auto;">{{ $trendIcon }} {{ abs(round($moodTrend, 1)) }}</span>
                        @else
                            <span style="color: #8E8E93; font-size: 12px; font-weight: 700; margin-left: auto;">-</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-2">Rata-rata minggu ini</p>
                </div>
                <div class="inner-card flex flex-col justify-center">
                    @php
                        $bestMood = \App\Models\HasilCheckInstan::where('user_id', $userId)->orderByDesc('poin_skor')->latest('created_at')->first();
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
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-2">Mood Terbaik</p>
                </div>
            </div>

            <div class="inner-card mb-6">
                <p style="font-size: 11px; font-weight: 800; color: #8E8E93; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Mood Hari Ini</p>
                @php
                    $todayMood = \App\Models\HasilCheckInstan::where('user_id', $userId)->whereDate('created_at', today())->latest('created_at')->first();
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

            <div class="inner-card mt-auto">
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
                            
                            $barColor = '#90EE90'; // Default Green
                            if ($avgScore > 0 && $avgScore <= 4) $barColor = '#FF8A8A'; // Red
                            elseif ($avgScore > 4 && $avgScore <= 6) $barColor = '#FFD54F'; // Yellow
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
                                <div style="width: 35px; height: {{ max($height, 15) }}px; background: {{ $barColor }}; border-radius: 10px; transition: all 0.3s; display: flex; align-items: flex-start; justify-content: center; padding-top: 4px;">
                                    <span style="font-size: 10px; font-weight: 800; color: rgba(0,0,0,0.5);">{{ number_format($avgScore, 1) }}</span>
                                </div>
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
        <div class="col-span-1 lg:col-span-3 section-card">
            <h3 class="card-title">Riwayat Jurnal</h3>
            @php
                $latestJournals = \App\Models\Journal::where('user_id', $userId)->latest()->take(3)->get();
            @endphp
            @if($latestJournals->isNotEmpty())
                <div class="flex flex-col gap-4 flex-1">
                    @foreach($latestJournals as $journal)
                        <a href="{{ route('journals.index') }}" class="block p-5 bg-white border border-gray-100 rounded-2xl hover:border-purple-200 hover:shadow-md transition-all group">
                            <p class="text-[10px] text-purple-400 font-black mb-2 uppercase tracking-widest">{{ $journal->created_at->translatedFormat('d M Y') }}</p>
                            <p class="text-[13px] text-gray-600 font-medium leading-relaxed group-hover:text-gray-900 transition-colors">{{ Str::limit($journal->content, 85) }}</p>
                        </a>
                    @endforeach
                    <div class="mt-auto text-center pt-2">
                        <a href="{{ route('journals.index') }}" class="btn-link">Lihat Semua Jurnal →</a>
                    </div>
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
        <div class="col-span-1 lg:col-span-4 section-card">
            <div class="card-title">
                <span>Sesi Konsultasi</span>
                <a href="{{ route('konseling.index') }}" class="btn-link" style="font-size: 12px; color: #8E8E93;">Atur →</a>
            </div>
            @php
                $upcomingSessions = \App\Models\SesiKonseling::with('profilKonselor')
                    ->where('user_id', $userId)
                    ->orderByRaw("FIELD(status, 'confirmed', 'rescheduled', 'approved', 'pending', 'change_requested', 'completed', 'system_cancelled', 'cancelled', 'rejected') ASC")
                    ->orderBy('jadwal', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            @if($upcomingSessions->isNotEmpty())
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($upcomingSessions as $session)
                        @php
                            $statusConfig = [
                                'pending'          => ['label' => 'Menunggu ACC', 'bg' => '#FFF8E1', 'color' => '#FFA000'],
                                'approved'         => ['label' => 'Pembayaran',   'bg' => '#E3F2FD', 'color' => '#1976D2'],
                                'confirmed'        => ['label' => 'Sesi Aktif',   'bg' => '#E8F5E9', 'color' => '#388E3C'],
                                'rescheduled'      => ['label' => 'Jadwal Ulang', 'bg' => '#E8F5E9', 'color' => '#388E3C'],
                                'change_requested' => ['label' => 'Request Ubah', 'bg' => '#F3E5F5', 'color' => '#7B1FA2'],
                                'completed'        => ['label' => 'Selesai',      'bg' => '#F5F5F5', 'color' => '#616161'],
                                'cancelled'        => ['label' => 'Batal',        'bg' => '#FFEBEE', 'color' => '#D32F2F'],
                                'system_cancelled' => ['label' => 'Batal Sistem', 'bg' => '#FFEBEE', 'color' => '#D32F2F'],
                                'rejected'         => ['label' => 'Ditolak',      'bg' => '#FFEBEE', 'color' => '#D32F2F'],
                            ];
                            $st = $statusConfig[$session->status] ?? ['label' => $session->status, 'bg' => '#F4EEFB', 'color' => '#A881C2'];
                            
                            $targetRoute = route('konseling.show', $session->profil_konselor_id);
                            if ($session->status === 'approved') {
                                $targetRoute = route('booking.checkout', $session->sesi_konseling_id);
                            } elseif (in_array($session->status, ['completed', 'cancelled', 'system_cancelled', 'rejected'])) {
                                $targetRoute = route('history.index');
                            }
                        @endphp
                        <div style="padding: 20px; background: #FAFAFA; border-radius: 24px; border: 1px solid #F1F1F1; display: flex; flex-direction: column; gap: 15px; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#FFFFFF'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.02)';" onmouseout="this.style.backgroundColor='#FAFAFA'; this.style.boxShadow='none';">
                            <a href="{{ $targetRoute }}" style="text-decoration: none; display: flex; align-items: center; gap: 15px; width: 100%;">
                                <div style="width: 48px; height: 48px; border-radius: 16px; background: #F4EEFB; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #A881C2/10;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($session->profilKonselor->nama) }}&background=A881C2&color=fff&bold=true&size=48" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="flex: 1;">
                                    <p style="font-size: 14px; font-weight: 700; color: #1A1A1A; margin-bottom: 2px;">{{ $session->profilKonselor->nama }}</p>
                                    <p style="font-size: 12px; color: #8E8E93; font-weight: 600;">{{ \Carbon\Carbon::parse($session->jadwal)->translatedFormat('d M, H:i') }}</p>
                                </div>
                                <div style="padding: 5px 10px; background: {{ $st['bg'] }}; color: {{ $st['color'] }}; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid {{ $st['color'] }}40;">
                                    {{ $st['label'] }}
                                </div>
                            </a>
                            
                            @if(in_array($session->status, ['confirmed', 'rescheduled']))
                                <a href="{{ route('konseling.room', $session->sesi_konseling_id) }}" style="text-decoration: none; background: #388E3C; color: white; text-align: center; padding: 10px; border-radius: 12px; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#2E7D32'" onmouseout="this.style.backgroundColor='#388E3C'">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Masuk Ruangan
                                </a>
                            @endif
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

    <!-- Riwayat Catatan Konselor Section -->
    <div class="section-card mt-8">
        <h3 class="card-title flex justify-between items-center mb-6">
            <span>Riwayat Catatan Konselor</span>
            <a href="{{ route('konseling.history') }}" class="btn-link">Lihat Semua →</a>
        </h3>
        
        @php
            $sessionHistory = \App\Models\SesiKonseling::with('profilKonselor')
                ->where('user_id', $userId)
                ->where('payment_status', 'paid')
                ->orderByRaw("CASE WHEN status IN ('completed', 'confirmed', 'rescheduled') THEN 0 ELSE 1 END ASC")
                ->orderBy('jadwal', 'desc')
                ->take(3)
                ->get();
        @endphp
        
        @if($sessionHistory->isEmpty())
            <div class="empty-state min-h-[150px] flex flex-col items-center justify-center py-8">
                <p class="empty-text text-gray-400">Belum ada riwayat sesi konseling selesai.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($sessionHistory as $history)
                    <div class="p-6 bg-gray-50/50 rounded-2xl border border-gray-100 flex flex-col gap-4">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-purple-50 p-1 flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($history->profilKonselor->nama) }}&background=A881C2&color=fff&size=100&bold=true" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-gray-950 text-sm">{{ $history->profilKonselor->nama }}</h4>
                                    <p class="text-xs text-gray-500 font-semibold">{{ $history->profilKonselor->spesialisasi }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-purple-50 text-[#A881C2] text-[10px] font-black uppercase tracking-wider border border-purple-100">
                                    {{ \Carbon\Carbon::parse($history->jadwal)->translatedFormat('d M Y, H:i') }}
                                </span>
                                
                                @if($history->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider border border-emerald-100">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-wider border border-red-100">
                                        {{ $history->status === 'system_cancelled' ? 'Batal Otomatis' : 'Dibatalkan' }}
                                    </span>
                                @endif
                                
                                @if($history->payment_status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-wider border border-green-100">
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-gray-50 text-gray-500 text-[10px] font-black uppercase tracking-wider border border-gray-100">
                                        Belum Bayar
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($history->status === 'completed' && $history->catatan_konselor)
                            <div class="p-4 bg-purple-50/50 rounded-xl border border-purple-100/30">
                                <div class="text-[11px] font-black text-[#8A64A4] uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Catatan Konselor
                                </div>
                                <p class="text-xs text-gray-700 font-medium leading-relaxed whitespace-pre-wrap">{{ $history->catatan_konselor }}</p>
                            </div>
                        @elseif($history->status === 'completed')
                            <div class="text-[11px] text-gray-400 font-semibold italic">Konselor belum menuliskan catatan evaluasi untuk sesi ini.</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

