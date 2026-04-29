@extends('layouts.dashboard')

@section('title', 'Homepage - MindFlow')

@section('styles')
<style>
    .home-wrapper { max-width: 900px; margin: 0 auto; animation: fadeUp 0.5s ease; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .quick-links { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px; }
    .quick-link {
        background: #fff; border: 1px solid #E5E7EB; border-radius: 16px; padding: 24px;
        text-decoration: none; color: inherit; transition: all 0.3s; display: flex; align-items: center; gap: 16px;
    }
    .quick-link:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); border-color: #D1D5DB; }
    .quick-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
    .quick-icon.purple { background: #F3E8FF; }
    .quick-icon.blue { background: #DBEAFE; }
    .quick-icon.green { background: #D1FAE5; }
    .quick-icon.orange { background: #FFEDD5; }
    .quick-title { font-size: 15px; font-weight: 700; color: #111827; }
    .quick-desc { font-size: 12px; color: #6B7280; margin-top: 2px; }
    .section-title { font-size: 18px; font-weight: 800; color: #111827; margin-bottom: 16px; }
    .info-card { background: #fff; border: 1px solid #E5E7EB; border-radius: 16px; padding: 24px; margin-bottom: 16px; }
</style>
@endsection

@section('content')
<div class="home-wrapper">
    <!-- Greeting -->
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #111827;">Selamat Datang! 👋</h1>
        <p style="font-size: 15px; color: #6B7280; margin-top: 6px;">Apa yang ingin kamu lakukan hari ini?</p>
    </div>

    <!-- Quick Links -->
    <div class="quick-links">
        <a href="{{ route('mood-tracker.index') }}" class="quick-link">
            <div class="quick-icon purple">📊</div>
            <div>
                <div class="quick-title">Mood Tracker</div>
                <div class="quick-desc">Cek kondisi emosionalmu</div>
            </div>
        </a>
        <a href="{{ route('journals.index') }}" class="quick-link">
            <div class="quick-icon green">📝</div>
            <div>
                <div class="quick-title">Jurnal Refleksi</div>
                <div class="quick-desc">Tulis ceritamu hari ini</div>
            </div>
        </a>
        <a href="{{ route('konseling.index') }}" class="quick-link">
            <div class="quick-icon blue">💬</div>
            <div>
                <div class="quick-title">Konseling</div>
                <div class="quick-desc">Bicara dengan konselor</div>
            </div>
        </a>
        <a href="{{ route('forum.index') }}" class="quick-link">
            <div class="quick-icon orange">🏛️</div>
            <div>
                <div class="quick-title">Forum</div>
                <div class="quick-desc">Berbagi dan saling dukung</div>
            </div>
        </a>
    </div>

    <!-- Recent Info -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <h3 class="section-title">📝 Jurnal Terakhir</h3>
            <div class="info-card">
                @php
                    $userId = Auth::id() ?? 1;
                    $latestJournal = \App\Models\Journal::where('user_id', $userId)->latest('updated_at')->first();
                @endphp
                @if($latestJournal)
                    <div style="font-size: 12px; font-weight: 600; color: #7C3AED; margin-bottom: 8px;">
                        {{ $latestJournal->updated_at->translatedFormat('d M Y, H:i') }}
                    </div>
                    <p style="font-size: 14px; color: #374151; line-height: 1.6;">{{ Str::limit($latestJournal->content, 150) }}</p>
                    <a href="{{ route('journals.index') }}" style="font-size: 13px; font-weight: 600; color: #7C3AED; margin-top: 12px; display: inline-block;">Lihat Semua →</a>
                @else
                    <p style="font-size: 14px; color: #9CA3AF; text-align: center; padding: 20px 0;">Belum ada jurnal. <a href="{{ route('journals.create') }}" style="color: #7C3AED; font-weight: 600;">Tulis sekarang</a></p>
                @endif
            </div>
        </div>
        <div>
            <h3 class="section-title">💬 Thread Terbaru</h3>
            <div class="info-card">
                @php
                    $latestThread = \App\Models\Forum::with('user')->latest('created_at')->first();
                @endphp
                @if($latestThread)
                    <div style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 6px;">{{ $latestThread->judul_thread }}</div>
                    <div style="font-size: 12px; color: #6B7280; margin-bottom: 8px;">oleh {{ $latestThread->user->nama_samaran ?? 'Anonim' }} · {{ $latestThread->created_at->diffForHumans() }}</div>
                    <p style="font-size: 14px; color: #374151;">{{ Str::limit($latestThread->konten, 100) }}</p>
                    <a href="{{ route('forum.index') }}" style="font-size: 13px; font-weight: 600; color: #7C3AED; margin-top: 12px; display: inline-block;">Lihat Forum →</a>
                @else
                    <p style="font-size: 14px; color: #9CA3AF; text-align: center; padding: 20px 0;">Belum ada thread. <a href="{{ route('forum.create') }}" style="color: #7C3AED; font-weight: 600;">Buat thread</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
