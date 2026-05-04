@extends('layouts.dashboard')

@section('title', 'Konsultasi - MindFlow')

@section('styles')
    /* --- Konselor Page --- */
    .konselor-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .konselor-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-select-wrapper {
        position: relative;
    }

    .filter-select {
        appearance: none;
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        color: #374151;
        padding: 8px 40px 8px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: box-shadow 0.2s, border-color 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 3px rgba(155, 118, 214, 0.15);
    }

    .filter-select-icon {
        pointer-events: none;
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        color: #6B7280;
    }

    .filter-select-icon svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: currentColor;
    }

    .btn-filter {
        background: var(--active-bg);
        color: var(--primary-purple);
        padding: 8px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .btn-filter:hover {
        background: #E9D5FF;
    }

    /* Empty state */
    .empty-konselor {
        background: #FFFFFF;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid #E5E7EB;
        padding: 48px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 450px;
        position: relative;
    }

    .empty-konselor .btn-buat-janji {
        position: absolute;
        top: 24px;
        right: 24px;
        background: #A881C2;
        color: #FFFFFF;
        padding: 8px 24px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .empty-konselor .btn-buat-janji:hover {
        background: #8A64A4;
    }

    .empty-konselor img {
        width: 160px;
        height: 160px;
        object-fit: contain;
        opacity: 0.6;
        margin-bottom: 24px;
    }

    .empty-konselor p {
        font-size: 13px;
        font-weight: 500;
        color: #6B7280;
    }

    /* Konselor grid */
    .konselor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 32px;
    }

    .konselor-card {
        background: #FFFFFF;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 2px 15px -3px rgba(0,0,0,0.07);
        border: 1px solid #F3F4F6;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: box-shadow 0.3s;
    }

    .konselor-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .konselor-card-gradient {
        height: 140px;
        background: linear-gradient(to bottom, #987FC5, #B5A1D6);
        position: relative;
    }

    .konselor-avatar-wrapper {
        position: absolute;
        top: 60px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }

    .konselor-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 4px solid #FFFFFF;
        background: #FFFFFF;
    }

    .konselor-card-body {
        padding: 50px 24px 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .konselor-card-body h4 {
        font-weight: 700;
        color: #111827;
        font-size: 17px;
        margin-bottom: 4px;
        transition: color 0.2s;
    }

    .konselor-card:hover .konselor-card-body h4 {
        color: #A881C2;
    }

    .konselor-card-body .spesialisasi {
        font-size: 13px;
        color: #6B7280;
        margin-bottom: 24px;
        font-weight: 500;
    }

    .konselor-card-footer {
        margin-top: auto;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .jadwal-badge {
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 10px;
        color: #6B7280;
        font-weight: 500;
        white-space: nowrap;
        background: #F9FAFB;
        flex: 1;
        text-align: left;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-pilih-sesi {
        background: #A881C2;
        color: #FFFFFF;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        white-space: nowrap;
    }

    .btn-pilih-sesi:hover {
        background: #8A64A4;
    }
@endsection

@section('content')
    <div class="konselor-header">
        <h3>Konselor</h3>

        <!-- PBI 27: Filter Spesialisasi -->
        <form action="{{ route('konseling.index') }}" method="GET" class="filter-form">
            <div class="filter-select-wrapper">
                <select name="spesialisasi" class="filter-select">
                    <option value="">-- Semua Spesialisasi --</option>
                    <option value="Kesehatan Mental" {{ request('spesialisasi') == 'Kesehatan Mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                    <option value="Konseling Akademik" {{ request('spesialisasi') == 'Konseling Akademik' ? 'selected' : '' }}>Konseling Akademik</option>
                    <option value="Karir" {{ request('spesialisasi') == 'Karir' ? 'selected' : '' }}>Karir</option>
                </select>
                <div class="filter-select-icon">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            <button type="submit" class="btn-filter">Filter</button>
        </form>
    </div>

    @if($konselors->isEmpty())
        <!-- Empty State -->
        <div class="empty-konselor">
            <button class="btn-buat-janji">Buat Janji</button>
            <img src="https://ui-avatars.com/api/?name=Cloud&background=fff&color=cbd5e1&size=160&font-size=0.33" alt="Empty">
            <p>Sepertinya kamu belum menjadwalkan sesi. Mulai bicara dengan ahli hari ini.</p>
        </div>
    @else
        <!-- Grid -->
        <div class="konselor-grid">
            @foreach($konselors as $k)
            <div class="konselor-card">
                <div class="konselor-card-gradient"></div>
                <div class="konselor-avatar-wrapper">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=random&color=fff&size=120" alt="{{ $k->nama }}" class="konselor-avatar">
                </div>
                <div class="konselor-card-body">
                    <h4>{{ $k->nama }}</h4>
                    <p class="spesialisasi">{{ $k->spesialisasi }}</p>
                    <div class="konselor-card-footer">
                        <div class="jadwal-badge">Senin - Rabu, 09.00 - 12.00</div>
                        <a href="{{ route('konseling.show', $k->id) }}" class="btn-pilih-sesi">Pilih Sesi</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endsection