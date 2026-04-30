@extends('layouts.dashboard')

@section('title', 'Detail Konselor - MindFlow')

@section('styles')
    /* --- Konselor Detail Page --- */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6B7280;
        font-weight: 500;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.2s;
        font-size: 14px;
    }

    .back-link:hover {
        color: #A881C2;
    }

    .back-link svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
    }

    /* Flash message */
    .flash-success-konseling {
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #047857;
        padding: 16px 24px;
        border-radius: 12px;
        margin-bottom: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .flash-success-konseling .flash-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .flash-success-konseling .flash-content svg {
        width: 24px;
        height: 24px;
        color: #10B981;
        fill: none;
        stroke: currentColor;
        flex-shrink: 0;
    }

    .flash-success-konseling .flash-content span {
        font-weight: 500;
        font-size: 14px;
    }

    .flash-close-btn {
        background: none;
        border: none;
        color: #10B981;
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s;
    }

    .flash-close-btn:hover {
        color: #047857;
    }

    .flash-close-btn svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
    }

    /* Detail layout */
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
    }

    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Profile card */
    .profile-card {
        background: #FFFFFF;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #F3F4F6;
        display: flex;
        gap: 32px;
    }

    @media (max-width: 600px) {
        .profile-card {
            flex-direction: column;
        }
    }

    .profile-avatar {
        width: 128px;
        height: 128px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        border: 1px solid #F3F4F6;
        flex-shrink: 0;
    }

    .profile-info h2 {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .spesialisasi-badge {
        display: inline-block;
        background: var(--active-bg);
        color: var(--primary-purple);
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .profile-section {
        margin-bottom: 24px;
    }

    .profile-section:last-child {
        margin-bottom: 0;
    }

    .profile-section h5 {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }

    .profile-section p {
        color: #4B5563;
        line-height: 1.6;
        font-size: 15px;
    }

    /* Booking card */
    .booking-card {
        background: #FFFFFF;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #E9D5FF;
        position: relative;
        overflow: hidden;
    }

    .booking-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, #987FC5, #B5A1D6);
    }

    .booking-card h5 {
        font-weight: 700;
        color: #111827;
        font-size: 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .booking-card h5 svg {
        width: 20px;
        height: 20px;
        color: var(--primary-purple);
        fill: none;
        stroke: currentColor;
    }

    .booking-form-group {
        margin-bottom: 24px;
    }

    .booking-form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
    }

    .booking-datetime {
        width: 100%;
        border: 1px solid #D1D5DB;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        color: #374151;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .booking-datetime:focus {
        outline: none;
        border-color: #A881C2;
        box-shadow: 0 0 0 3px rgba(168, 129, 194, 0.15);
    }

    .btn-konfirmasi {
        width: 100%;
        background: #A881C2;
        color: #FFFFFF;
        padding: 12px 16px;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-konfirmasi:hover {
        background: #8A64A4;
    }

    .btn-konfirmasi svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: currentColor;
    }
@endsection

@section('content')
    <div style="max-width: 900px;">
        <a href="{{ route('konseling.index') }}" class="back-link">
            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Konselor
        </a>

        @if(session('success'))
            <div class="flash-success-konseling">
                <div class="flash-content">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="flash-close-btn" onclick="this.parentElement.style.display='none'">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        <div class="detail-grid">
            <!-- Profil Detail -->
            <div>
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($konselor->nama) }}&background=random&color=fff&size=120" alt="{{ $konselor->nama }}" class="profile-avatar">
                    <div class="profile-info">
                        <h2>{{ $konselor->nama }}</h2>
                        <span class="spesialisasi-badge">{{ $konselor->spesialisasi }}</span>

                        <div class="profile-section">
                            <h5>Biografi</h5>
                            <p>{{ $konselor->biografi }}</p>
                        </div>
                        <div class="profile-section">
                            <h5>Keahlian</h5>
                            <p>{{ $konselor->keahlian }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div>
                <div class="booking-card">
                    <h5>
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Booking Sesi
                    </h5>

                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="konselor_id" value="{{ $konselor->id }}">

                        <div class="booking-form-group">
                            <label>Pilih Jadwal Konsultasi</label>
                            <input type="datetime-local" name="jadwal" class="booking-datetime" required>
                        </div>

                        <button type="submit" class="btn-konfirmasi">
                            Konfirmasi Reservasi
                            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection