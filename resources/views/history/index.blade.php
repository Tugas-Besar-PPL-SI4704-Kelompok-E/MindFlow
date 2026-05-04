@extends('layouts.dashboard')

@section('title', 'History Lengkap - MindFlow')

@section('styles')
    .history-section {
        max-width: 900px;
        margin: 0 auto;
    }

    .section-header {
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .section-subtitle {
        font-size: 14px;
        color: #6B7280;
    }

    /* History Table Card */
    .history-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .history-table th {
        background-color: #F9FAFB;
        padding: 16px 24px;
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #E5E7EB;
    }

    .history-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }

    .history-table tr:last-child td {
        border-bottom: none;
    }

    .history-table tr:hover {
        background-color: #F9FAFB;
    }

    /* Activity Type Cell */
    .activity-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-wrapper.blue {
        background-color: #EFF6FF;
        color: #3B82F6;
    }

    .icon-wrapper.indigo {
        background-color: #EEF2FF;
        color: #6366F1;
    }

    .icon-wrapper.purple {
        background-color: #F3E8FF;
        color: #A855F7;
    }

    .activity-info .activity-name {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 2px;
    }

    /* Date and Time Cell */
    .datetime-cell .date {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 2px;
    }

    .datetime-cell .time {
        font-size: 12px;
        color: #6B7280;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 500;
        background-color: #ECFDF5;
        color: #047857;
        border: 1px solid #A7F3D0;
    }

    /* Empty state */
    .empty-state {
        padding: 60px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .empty-state svg {
        margin-bottom: 16px;
        color: #D1D5DB;
    }

    .empty-state p {
        font-size: 14px;
        font-weight: 500;
        color: #6B7280;
    }

    /* Button Kembali */
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
    <div class="history-section">
        <div class="section-header">
            <h1 class="section-title">History Lengkap</h1>
            <p class="section-subtitle">Daftar riwayat semua aktivitas Anda di MindFlow</p>
        </div>

        <div class="history-card">
            @if ($histories->isEmpty())
                <div class="empty-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <p>Belum ada riwayat aktivitas.</p>
                </div>
            @else
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Jenis Aktivitas</th>
                            <th>Tanggal & Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
                            <tr>
                                <td>
                                    <div class="activity-cell">
                                        <div class="icon-wrapper {{ $history->color }}">
                                            @if($history->icon === 'zap')
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                            @elseif($history->icon === 'search')
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            @else
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="activity-info">
                                            <div class="activity-name">{{ $history->type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="datetime-cell">
                                        <div class="date">{{ \Carbon\Carbon::parse($history->date)->translatedFormat('d F Y') }}</div>
                                        <div class="time">{{ \Carbon\Carbon::parse($history->date)->format('H:i') }} WIB</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge">{{ $history->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
            <a href="{{ route('journals.index') }}" class="btn-history">
                <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali
            </a>
        </div>
    </div>
@endsection
