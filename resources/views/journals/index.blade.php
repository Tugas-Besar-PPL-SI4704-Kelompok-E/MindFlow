@extends('layouts.dashboard')

@section('title', 'Jurnal Refleksi Mandiri - MindFlow')

@section('styles')
    .journal-section {
        max-width: 800px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    /* Create new journal card */
    .journal-create-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        background: #FFFFFF;
        padding: 40px 20px;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        cursor: pointer;
    }

    .journal-create-card:hover {
        background-color: #F9FAFB;
    }

    .journal-create-card:hover .create-plus,
    .journal-create-card:hover .create-text {
        color: var(--primary-purple);
    }

    .create-icon-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .create-plus {
        font-size: 32px;
        font-weight: 300;
        color: #6B7280;
        transition: color 0.2s;
    }

    .create-text {
        font-size: 12px;
        font-weight: 500;
        color: #9CA3AF;
        transition: color 0.2s;
    }

    /* Flash message */
    .flash-success {
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #047857;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 16px;
        font-size: 14px;
        font-weight: 500;
    }

    /* Journal grid */
    .journal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .journal-card {
        border: 1px solid #E5E7EB;
        background: #FFFFFF;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        padding: 20px;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s;
    }

    .journal-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .journal-date {
        font-size: 11px;
        font-weight: 700;
        color: var(--primary-purple);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }

    .journal-date .edited-badge {
        margin-left: 4px;
        color: #9CA3AF;
        text-transform: none;
        font-weight: 400;
    }

    .journal-content {
        color: #374151;
        font-size: 14px;
        margin-bottom: 20px;
        flex-grow: 1;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .journal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        border-top: 1px solid #F3F4F6;
        padding-top: 12px;
        margin-top: auto;
    }

    .btn-edit {
        font-size: 12px;
        padding: 6px 12px;
        color: #6D28D9;
        background: #F3E8FF;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.2s;
    }

    .btn-edit:hover {
        background: #EDE9FE;
    }

    .btn-delete {
        font-size: 12px;
        padding: 6px 12px;
        color: #DC2626;
        background: #FEF2F2;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-delete:hover {
        background: #FEE2E2;
    }

    /* Empty state */
    .empty-state {
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        padding: 60px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .empty-state p {
        font-size: 12px;
        font-weight: 500;
        color: #9CA3AF;
    }

    /* Mood calendar */
    .mood-calendar-header {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .mood-nav-btn {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #A855F7;
        color: #FFFFFF;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .mood-nav-btn:hover {
        background: #9333EA;
    }

    .mood-nav-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        fill: none;
    }

    .mood-month-label {
        font-weight: 800;
        color: #111827;
        font-size: 13px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .mood-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .mood-day {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #FFFFFF;
        font-weight: 700;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: opacity 0.2s;
        cursor: default;
    }

    .mood-day:hover {
        opacity: 0.8;
    }

    .mood-default { background: #D8B4E2; }
    .mood-happy { background: #86EFAC; }
    .mood-neutral { background: #FDE047; }
    .mood-stressed { background: #F87171; }

    .current-day {
        border: 2px solid #6D28D9;
        font-weight: 800;
        box-shadow: 0 0 8px rgba(109, 40, 217, 0.4);
    }
    .calendar-card {
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        padding: 24px 40px;
    }
    .btn-history {
        display: inline-flex;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: #FFFFFF;
        background-color: var(--primary-purple, #9B76D6);
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.2s, transform 0.1s;
        box-shadow: 0 2px 8px rgba(155, 118, 214, 0.4);
    }

    .btn-history:hover {
        background-color: #875ec2;
        transform: translateY(-1px);
    }

    .btn-history svg {
        width: 16px;
        height: 16px;
        margin-right: 6px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
    }
@endsection

@section('content')
    {{-- Jurnal Section --}}
    <div class="journal-section" style="margin-bottom: 40px;">
        <h3 class="section-title">Jurnal</h3>
        <a href="{{ route('journals.create') }}" class="journal-create-card">
            <div class="create-icon-row">
                {{-- Book Illustration SVG --}}
                <svg width="60" height="50" viewBox="0 0 60 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 15L45 5L50 15L20 25L15 15Z" fill="#E9D8FD" stroke="#6B7280" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M15 15V25L45 15V5L15 15Z" fill="#F3E8FF" stroke="#6B7280" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M20 25V35L50 25V15L20 25Z" fill="#D8B4E2" stroke="#6B7280" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M15 25L20 35M45 15L50 25" stroke="#6B7280" stroke-width="2" stroke-linecap="round"/>
                    <path d="M25 10L40 5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M30 15L45 10" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span class="create-plus">+</span>
            </div>
            <p class="create-text">Ketuk untuk menulis jurnal</p>
        </a>
    </div>

    {{-- Riwayat Jurnal Section --}}
    <div class="journal-section" style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <h3 class="section-title" style="margin-bottom: 0;">Riwayat Jurnal</h3>
            <a href="{{ route('history.index') }}" class="btn-history">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Lihat History Lengkap
            </a>
        </div>
        @if (session('success'))
            <div class="flash-success" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($journals->isEmpty())
            <div class="empty-state">
                <svg width="120" height="60" viewBox="0 0 120 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom: 16px;">
                    <path d="M30 45C22 45 18 38 22 32C23 30 25 29 27 29C28 22 36 18 42 22C46 15 58 13 65 20C70 14 82 17 84 25C90 24 95 28 94 34C98 36 96 45 88 45H30Z" fill="white" stroke="#D1D5DB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M40 35C38 32 40 28 45 28C48 24 55 24 58 29" stroke="#E5E7EB" stroke-width="2" stroke-linecap="round"/>
                    <path d="M100 50C97 50 95 47 97 45C98 44 98 43 99 43C100 40 103 39 105 40C107 38 111 39 112 42C114 41 116 43 116 45C118 46 117 50 114 50H100Z" fill="white" stroke="#E5E7EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p>Jurnal masih kosong</p>
            </div>
        @else
            <div class="journal-grid">
                @foreach ($journals as $journal)
                    <div class="journal-card">
                        <div class="journal-date">
                            {{ $journal->updated_at->translatedFormat('d M Y, H:i') }}
                            @if($journal->created_at->ne($journal->updated_at))
                                <span class="edited-badge">(Diedit)</span>
                            @endif
                        </div>

                        <div class="journal-content">
                            {{ Str::limit($journal->content, 120, '...') }}
                        </div>

                        <div class="journal-actions">
                            <a href="{{ route('journals.edit', $journal->journal_id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('journals.destroy', $journal->journal_id) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Kalender Mood Section --}}
    <div class="journal-section" style="margin-bottom: 40px; padding-bottom: 40px;">
        <h3 class="section-title">Kalender Mood</h3>
        <div class="calendar-card">
            <div class="mood-calendar-header">
                <button class="mood-nav-btn">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="mood-month-label">{{ $currentMonth }}</span>
                <button class="mood-nav-btn">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <div class="mood-grid">
               @for ($i = 1; $i <= $daysInMonth; $i++)
                   @php
                       $moodClass = 'mood-default';
                       if (isset($moodData[$i])) {
                           if ($moodData[$i] === 'senang') {
                               $moodClass = 'mood-happy';
                           } elseif ($moodData[$i] === 'biasa') {
                               $moodClass = 'mood-neutral';
                           } elseif ($moodData[$i] === 'stres') {
                               $moodClass = 'mood-stressed';
                           }
                       }
                       $isCurrentDay = (isset($currentDay) && $i == $currentDay) ? 'current-day' : '';
                   @endphp
                   <div class="mood-day {{ $moodClass }} {{ $isCurrentDay }}" title="Tanggal {{ $i }}">{{ $i }}</div>
               @endfor
            </div>
        </div>
    </div>
@endsection
