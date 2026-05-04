<<<<<<< HEAD
@extends('journals.layout')
=======
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
>>>>>>> 133792b (TBPSKE-15 : PBI-15 : CRUD editor teks untuk refleksi harian)

@section('content')
<!-- Left section (Main Dashboard Content) -->
<div class="flex-grow flex flex-col h-full overflow-y-auto px-8 py-8 md:px-[60px]">
    <!-- Top Header -->
    <div class="flex justify-between items-center mb-10 w-full max-w-[800px] mx-auto">
        <div class="flex items-center space-x-4">
            <div class="w-[50px] h-[50px] rounded-full overflow-hidden shadow-sm bg-gray-100 flex-shrink-0">
                 <img src="https://ui-avatars.com/api/?name=Asep&background=E2E8F0&color=475569" alt="Asep" class="w-full h-full object-cover" />
            </div>
            <div>
                <h2 class="text-[22px] font-extrabold text-[#111827] tracking-tight leading-tight">Welcome, Asep!</h2>
                <p class="text-[#6B7280] text-[14px] font-medium mt-0.5">How's your day?</p>
            </div>
        </div>
        <div class="relative hidden sm:block">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" placeholder="Cari..." class="block w-[280px] pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-700 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 shadow-sm" />
        </div>
    </div>

    <!-- Jurnal Section -->
    <div class="mb-10 w-full max-w-[800px] mx-auto">
        <h3 class="text-[16px] font-bold text-[#111827] mb-3">Jurnal</h3>
        <a href="{{ route('journals.create') }}" class="block w-full border border-gray-200 rounded-[14px] bg-white hover:bg-gray-50 shadow-[0_2px_10px_rgba(0,0,0,0.02)] transition duration-200 py-[40px] flex flex-col items-center justify-center cursor-pointer group">
            
            <div class="flex items-center justify-center space-x-3 mb-2">
                <!-- Book Illustration SVG -->
                <svg width="60" height="50" viewBox="0 0 60 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 15L45 5L50 15L20 25L15 15Z" fill="#E9D8FD" stroke="#6B7280" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M15 15V25L45 15V5L15 15Z" fill="#F3E8FF" stroke="#6B7280" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M20 25V35L50 25V15L20 25Z" fill="#D8B4E2" stroke="#6B7280" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M15 25L20 35M45 15L50 25" stroke="#6B7280" stroke-width="2" stroke-linecap="round"/>
                    <path d="M25 10L40 5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M30 15L45 10" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span class="text-[32px] font-light text-gray-500 group-hover:text-purple-600 transition">+</span>
            </div>
            
            <p class="text-[#9CA3AF] text-[12px] font-medium group-hover:text-purple-600 transition">Ketuk untuk menulis jurnal</p>
        </a>
    </div>

<<<<<<< HEAD
    <!-- Riwayat Jurnal Section -->
    <div class="mb-10 w-full max-w-[800px] mx-auto">
        <h3 class="text-[16px] font-bold text-[#111827] mb-3">Riwayat Jurnal</h3>
        
        {{-- Flash message jika berhasil melakukan operasi --}}
=======
    {{-- Riwayat Jurnal Section --}}
    <div class="journal-section" style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <h3 class="section-title" style="margin-bottom: 0;">Riwayat Jurnal</h3>
            <a href="{{ route('history.index') }}" class="btn-history">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Lihat History Lengkap
            </a>
        </div>

>>>>>>> 133792b (TBPSKE-15 : PBI-15 : CRUD editor teks untuk refleksi harian)
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-4 shadow-sm text-sm font-medium" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        {{-- Cek apakah ada jurnal --}}
        @if ($journals->isEmpty())
            <div class="border border-gray-200 rounded-[14px] bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] py-[60px] flex flex-col items-center justify-center">
                <!-- Clouds Illustration SVG -->
                <svg width="120" height="60" viewBox="0 0 120 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-4">
                    <path d="M30 45C22 45 18 38 22 32C23 30 25 29 27 29C28 22 36 18 42 22C46 15 58 13 65 20C70 14 82 17 84 25C90 24 95 28 94 34C98 36 96 45 88 45H30Z" fill="white" stroke="#D1D5DB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M40 35C38 32 40 28 45 28C48 24 55 24 58 29" stroke="#E5E7EB" stroke-width="2" stroke-linecap="round"/>
                    <!-- Small cloud -->
                    <path d="M100 50C97 50 95 47 97 45C98 44 98 43 99 43C100 40 103 39 105 40C107 38 111 39 112 42C114 41 116 43 116 45C118 46 117 50 114 50H100Z" fill="white" stroke="#E5E7EB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p class="text-[#9CA3AF] text-[12px] font-medium">Jurnal masih kosong</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($journals as $journal)
                    <div class="border border-gray-200 bg-white rounded-[14px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-5 flex flex-col hover:shadow-md transition">
                        <div class="text-[11px] font-bold text-purple-600 mb-2 uppercase tracking-wide">
                            {{ $journal->updated_at->translatedFormat('d M Y, H:i') }}
                            @if($journal->created_at->ne($journal->updated_at))
                                <span class="ml-1 text-gray-400 normal-case font-normal">(Diedit)</span>
                            @endif
                        </div>
                        
                        <div class="text-[#374151] text-[14px] mb-5 flex-grow line-clamp-3 leading-relaxed">
                            {{ Str::limit($journal->content, 120, '...') }}
                        </div>
                        
                        <div class="flex justify-end gap-2 border-t border-gray-100 pt-3 mt-auto">
                            <a href="{{ route('journals.edit', $journal->journal_id) }}" class="text-[12px] px-3 py-1.5 text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-lg transition font-semibold">Edit</a>
                            <form action="{{ route('journals.destroy', $journal->journal_id) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[12px] px-3 py-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition font-semibold">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Kalender Mood Section -->
    <div class="mb-10 pb-10 w-full max-w-[800px] mx-auto">
        <h3 class="text-[16px] font-bold text-[#111827] mb-3">Kalender Mood</h3>
        <div class="border border-gray-200 rounded-[14px] bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)] py-6 px-10 overflow-x-auto">
            
            <div class="flex justify-center items-center mb-6 space-x-4">
                <button class="w-6 h-6 rounded-full bg-[#A855F7] hover:bg-purple-600 text-white flex items-center justify-center transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="font-extrabold text-[#111827] text-[13px] tracking-wide uppercase">{{ $currentMonth }}</span>
                <button class="w-6 h-6 rounded-full bg-[#A855F7] hover:bg-purple-600 text-white flex items-center justify-center transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
            
            <!-- Dynamic Grid -->
            <div class="flex flex-wrap gap-2.5 justify-center lg:px-4">
               @for ($i = 1; $i <= $daysInMonth; $i++)
                   @php
                       // Default background (Ungu muda/abu-abu base)
                       $bgClass = 'bg-[#D8B4E2]';
                       
                       // Jika ada data mood untuk tanggal ini dari database statis controller
                       if (isset($moodData[$i])) {
                           if ($moodData[$i] === 'senang') {
                               $bgClass = 'bg-[#86EFAC]'; // Hijau
                           } elseif ($moodData[$i] === 'biasa') {
                               $bgClass = 'bg-[#FDE047]'; // Kuning
                           } elseif ($moodData[$i] === 'stres') {
                               $bgClass = 'bg-[#F87171]'; // Merah
                           }
                       }
                       $isCurrentDay = (isset($currentDay) && $i == $currentDay) ? 'current-day' : '';
                   @endphp
<<<<<<< HEAD
                   <div class="w-[34px] h-[34px] flex items-center justify-center text-[13px] text-white font-bold {{ $bgClass }} rounded shadow-sm hover:opacity-80 transition cursor-default" title="Tanggal {{ $i }}">{{ $i }}</div>
=======
                   <div class="mood-day {{ $moodClass }} {{ $isCurrentDay }}" title="Tanggal {{ $i }}">{{ $i }}</div>
>>>>>>> 133792b (TBPSKE-15 : PBI-15 : CRUD editor teks untuk refleksi harian)
               @endfor
            </div>
        </div>
    </div>
</div>

<!-- Right section (Sidebar Jadwal) -->
<div class="w-[340px] flex-shrink-0 border-l border-gray-200 bg-white h-full px-6 py-8 hidden xl:block overflow-y-auto">
    <div class="flex justify-between items-center mb-10 pt-2">
        <h3 class="text-[14px] font-extrabold text-[#111827]">Jadwal Konsultasi Mendatang</h3>
        <a href="#" class="text-[12px] text-[#A855F7] font-semibold hover:underline">Batalkan</a>
    </div>
    
    <div class="mt-[100px] flex flex-col items-center justify-center text-center">
        <!-- Exact Illustration Placeholder approximation -->
        <div class="mb-4 relative w-[180px] h-[140px]">
            <svg width="180" height="140" viewBox="0 0 180 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Board -->
                <rect x="25" y="30" width="130" height="70" stroke="#4B5563" stroke-width="2" fill="white"/>
                <!-- Board Stand -->
                <line x1="25" y1="30" x2="25" y2="10" stroke="#E5E7EB" stroke-width="4"/>
                <line x1="155" y1="30" x2="155" y2="10" stroke="#E5E7EB" stroke-width="4"/>
                <line x1="35" y1="100" x2="25" y2="130" stroke="#4B5563" stroke-width="2"/>
                <line x1="145" y1="100" x2="155" y2="130" stroke="#4B5563" stroke-width="2"/>
                <!-- Board content lines -->
                <rect x="35" y="40" width="40" height="10" fill="#E2E8F0" rx="2"/>
                <rect x="35" y="55" width="40" height="40" fill="#E2E8F0" rx="2"/>
                <rect x="85" y="40" width="60" height="15" fill="#E2E8F0" rx="2"/>
                <rect x="85" y="60" width="30" height="15" fill="#E2E8F0" rx="2"/>
                <!-- Character silhouette approximation -->
                <circle cx="125" cy="55" r="10" fill="#FCA5A5"/>
                <path d="M115 70C115 65 135 65 135 70C135 85 125 90 125 90L130 110L121 110L117 95L115 110L106 110L112 90C112 90 115 85 115 70Z" fill="#3B82F6"/>
                <!-- holding an iPad/board -->
                <rect x="105" y="65" width="15" height="20" fill="#9CA3AF" rx="1"/>
            </svg>
        </div>
        
        <p class="text-[12px] text-[#6B7280] font-medium leading-[1.6]">Tidak ada jadwal ditemukan<br/>Ketuk untuk menambahkan jadwal</p>
    </div>
</div>
@endsection
