@extends('layouts.app')

@section('content')

{{-- Back Button --}}
<div class="mb-6">
    <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.artikel.index') : route('artikel.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#A881C2] font-semibold text-sm transition-all group" id="btn-back-artikel">
        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ auth()->check() && auth()->user()->role === 'admin' ? 'Kembali ke Kelola Artikel' : 'Kembali ke Artikel' }}
    </a>
</div>

{{-- Article Container --}}
<div class="artikel-show-wrapper">
    {{-- Main Article --}}
    <article class="artikel-show-main" id="artikel-detail-{{ $artikel->artikel_id }}">
        {{-- Cover Image --}}
        <div class="artikel-show-cover">
            @if($artikel->gambar_cover)
                <img src="{{ asset('storage/' . $artikel->gambar_cover) }}" alt="{{ $artikel->judul }}" class="artikel-show-cover-img">
            @else
                <div class="artikel-show-cover-placeholder">
                    <div class="artikel-show-cover-icon">
                        <svg class="w-12 h-12 text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h10"/>
                        </svg>
                    </div>
                </div>
            @endif

            {{-- Kategori Badge (overlay) --}}
            @if($artikel->kategori)
                @php
                    $katColors = match($artikel->kategori) {
                        'Kesehatan Mental' => 'bg-emerald-500/90 text-white',
                        'Tips & Trik' => 'bg-blue-500/90 text-white',
                        'Motivasi' => 'bg-amber-500/90 text-white',
                        'Edukasi' => 'bg-violet-500/90 text-white',
                        default => 'bg-gray-500/90 text-white',
                    };
                @endphp
                <div class="absolute top-5 left-5">
                    <span class="inline-flex items-center px-4 py-1.5 {{ $katColors }} rounded-xl text-[11px] font-black uppercase tracking-wider backdrop-blur-sm shadow-md">
                        {{ $artikel->kategori }}
                    </span>
                </div>
            @endif

            {{-- Action Buttons --}}
            @auth
            <div class="absolute top-5 right-5 flex items-center gap-2">
                {{-- Report Button --}}
                @if(Auth::user()->role !== 'admin')
                <button 
                    type="button" 
                    onclick="openReportModal()"
                    class="w-10 h-10 flex items-center justify-center bg-white/80 hover:bg-white text-gray-500 hover:text-red-500 rounded-xl transition-all shadow-sm backdrop-blur-sm group/rpt"
                    title="Laporkan Artikel"
                    id="btn-report-artikel"
                >
                    <svg class="w-5 h-5 group-hover/rpt:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                    </svg>
                </button>
                @endif

                {{-- Bookmark Button --}}
                <button 
                    type="button" 
                    onclick="toggleBookmark({{ $artikel->artikel_id }}, this)"
                    class="w-10 h-10 flex items-center justify-center bg-white/80 hover:bg-white rounded-xl transition-all group/bm {{ $artikel->isBookmarkedBy(Auth::id()) ? 'text-[#A881C2]' : 'text-gray-400 hover:text-[#A881C2] shadow-sm backdrop-blur-sm' }}"
                    title="{{ $artikel->isBookmarkedBy(Auth::id()) ? 'Hapus Bookmark' : 'Bookmark' }}"
                >
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="{{ $artikel->isBookmarkedBy(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </button>
            </div>
            @endauth
        </div>

        {{-- Article Header --}}
        <div class="artikel-show-header">
            {{-- Meta Info --}}
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <div class="flex items-center gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($artikel->admin->nama_asli ?? 'Admin') }}&background=E8DEFA&color=6B3FA0&size=36&bold=true&font-size=0.42" alt="Author" class="w-8 h-8 rounded-full ring-2 ring-purple-100">
                    <div>
                        <span class="text-[13px] font-bold text-gray-800 block leading-tight">{{ $artikel->admin->nama_asli ?? 'Admin MindFlow' }}</span>
                        <span class="text-[11px] font-medium text-gray-400">Admin MindFlow</span>
                    </div>
                </div>
                <span class="text-gray-200 text-lg">•</span>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[12px] font-bold text-gray-400 uppercase tracking-wide">{{ $artikel->created_at->translatedFormat('d F Y') }}</span>
                </div>
                <span class="text-gray-200 text-lg">•</span>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @php
                        $wordCount = str_word_count(strip_tags($artikel->konten));
                        $readTime = max(1, ceil($wordCount / 200));
                    @endphp
                    <span class="text-[12px] font-bold text-gray-400">{{ $readTime }} menit baca</span>
                </div>
            </div>

            {{-- Title --}}
            <h1 class="artikel-show-title" id="artikel-judul">{{ $artikel->judul }}</h1>

            {{-- Divider --}}
            <div class="w-16 h-1.5 bg-gradient-to-r from-[#A881C2] to-[#C4A8E0] rounded-full mb-8"></div>
        </div>

        {{-- Article Body --}}
        <div class="artikel-show-body" id="artikel-konten">
            @foreach(explode("\n", $artikel->konten) as $paragraph)
                @if(trim($paragraph) !== '')
                    @php
                        // Bold text formatting: **text** → <strong>text</strong>
                        $formatted = e(trim($paragraph));
                        $formatted = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $formatted);
                        // Format numbered items
                        $formatted = preg_replace('/^(\d+\.\s)/', '<span class="artikel-list-number">$1</span>', $formatted);
                        // Format bullet items  
                        $formatted = preg_replace('/^-\s(.+)/', '<span class="artikel-bullet">•</span> $1', $formatted);
                        // Format quoted text: "text" → styled
                        $formatted = preg_replace('/&quot;(.+?)&quot;/', '<span class="artikel-quote-inline">"$1"</span>', $formatted);
                    @endphp
                    <p>{!! $formatted !!}</p>
                @endif
            @endforeach
        </div>

        {{-- Article Footer --}}
        <div class="artikel-show-footer">
            {{-- Tags/Kategori --}}
            @if($artikel->kategori)
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="text-[12px] font-bold text-gray-400 uppercase tracking-wider">Kategori:</span>
                <a href="{{ route('artikel.index', ['kategori' => $artikel->kategori]) }}" class="inline-flex items-center px-3 py-1 bg-purple-50 text-[#A881C2] rounded-lg text-[12px] font-bold hover:bg-purple-100 transition-all">
                    {{ $artikel->kategori }}
                </a>
            </div>
            @endif

            {{-- Share Prompt --}}
            <div class="artikel-show-share-card">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#A881C2] to-[#9B6FB8] rounded-xl flex items-center justify-center shadow-md shadow-purple-200 flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[14px] font-bold text-gray-800 leading-tight">Apakah artikel ini membantu?</p>
                        <p class="text-[12px] text-gray-400 font-medium">Bagikan kepada teman yang mungkin membutuhkan 💜</p>
                    </div>
                </div>
            </div>
        </div>
    </article>

    {{-- Related Articles Sidebar --}}
    @if($artikelTerkait->count() > 0)
    <aside class="artikel-show-sidebar">
        <h3 class="text-[15px] font-bold text-gray-900 mb-5 flex items-center gap-2">
            <div class="w-1 h-5 bg-gradient-to-b from-[#A881C2] to-[#C4A8E0] rounded-full"></div>
            Artikel Terkait
        </h3>
        <div class="flex flex-col gap-4">
            @foreach($artikelTerkait as $terkait)
                <a href="{{ route('artikel.show', $terkait->artikel_id) }}" class="artikel-related-card group" id="artikel-terkait-{{ $terkait->artikel_id }}">
                    {{-- Thumbnail --}}
                    <div class="artikel-related-thumb">
                        @if($terkait->gambar_cover)
                            <img src="{{ asset('storage/' . $terkait->gambar_cover) }}" alt="{{ $terkait->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-50 to-indigo-50">
                                <svg class="w-6 h-6 text-[#A881C2]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h10"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        @if($terkait->kategori)
                            @php
                                $terkaitKatColors = match($terkait->kategori) {
                                    'Kesehatan Mental' => 'text-emerald-600 bg-emerald-50',
                                    'Tips & Trik' => 'text-blue-600 bg-blue-50',
                                    'Motivasi' => 'text-amber-600 bg-amber-50',
                                    'Edukasi' => 'text-violet-600 bg-violet-50',
                                    default => 'text-gray-600 bg-gray-50',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 {{ $terkaitKatColors }} rounded-md text-[9px] font-black uppercase tracking-wider mb-1.5">
                                {{ $terkait->kategori }}
                            </span>
                        @endif
                        <h4 class="text-[13px] font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-[#A881C2] transition-colors">
                            {{ $terkait->judul }}
                        </h4>
                        <span class="text-[11px] text-gray-400 font-medium mt-1 block">{{ $terkait->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- See All Articles Button --}}
        <a href="{{ route('artikel.index') }}" class="mt-5 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-purple-50 hover:bg-purple-100 text-[#A881C2] rounded-xl text-[12px] font-bold transition-all group/btn">
            Lihat Semua Artikel
            <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </aside>
    @endif
</div>

{{-- Report Modal --}}
@auth
    @if(Auth::user()->role !== 'admin')
    <div id="reportModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[100] flex items-center justify-center animate-[fadeIn_0.2s_ease-out]">
        <div class="bg-white rounded-[28px] w-full max-w-md shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Laporkan Artikel
                </h3>
                <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('artikel.report', $artikel->artikel_id) }}" method="POST" class="m-0">
                @csrf
                <div class="p-6 space-y-4">
                    <div class="bg-red-50/50 border border-red-100 rounded-2xl p-4 flex gap-3">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-red-700 leading-relaxed font-medium">
                            Laporkan jika artikel ini memiliki masalah konten, pelanggaran hak cipta, informasi salah, atau konten tidak pantas. Tim admin kami akan segera meninjau laporan Anda.
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Alasan Pelaporan</label>
                        <textarea 
                            name="reason" 
                            rows="4" 
                            class="w-full border border-gray-200 rounded-2xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-red-500/10 focus:border-red-400 bg-gray-50 focus:bg-white resize-none text-gray-700 font-medium transition-all placeholder-gray-400" 
                            placeholder="Tuliskan detail masalah pada artikel ini..." 
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-200 bg-gray-100 rounded-xl transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-all shadow-md shadow-red-500/20 active:scale-95">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endauth

@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── Article Show Layout ── */
    .artikel-show-wrapper {
        display: flex;
        gap: 32px;
        align-items: flex-start;
    }

    .artikel-show-main {
        flex: 1;
        min-width: 0;
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 4px 20px -4px rgba(0,0,0,0.03);
        border: 1px solid #f3f4f6;
    }

    .artikel-show-sidebar {
        width: 280px;
        flex-shrink: 0;
        position: sticky;
        top: 24px;
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 4px 20px -4px rgba(0,0,0,0.03);
        border: 1px solid #f3f4f6;
    }

    /* ── Cover Image ── */
    .artikel-show-cover {
        position: relative;
        width: 100%;
        aspect-ratio: 21 / 9;
        overflow: hidden;
        background: linear-gradient(135deg, #f3e8f5 0%, #e8e0f0 50%, #ddd5ee 100%);
    }

    .artikel-show-cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .artikel-show-cover-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .artikel-show-cover-icon {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    /* ── Header ── */
    .artikel-show-header {
        padding: 32px 36px 0;
    }

    .artikel-show-title {
        font-size: 26px;
        font-weight: 800;
        color: #111827;
        line-height: 1.3;
        margin-bottom: 16px;
        letter-spacing: -0.01em;
    }

    /* ── Body ── */
    .artikel-show-body {
        padding: 0 36px 32px;
    }

    .artikel-show-body p {
        font-size: 15px;
        line-height: 1.85;
        color: #4b5563;
        margin-bottom: 16px;
    }

    .artikel-show-body p:last-child {
        margin-bottom: 0;
    }

    .artikel-show-body strong {
        color: #1f2937;
        font-weight: 700;
    }

    .artikel-list-number {
        color: #A881C2;
        font-weight: 700;
    }

    .artikel-bullet {
        color: #A881C2;
        font-weight: 700;
        margin-right: 4px;
    }

    .artikel-quote-inline {
        color: #6b4c8a;
        font-style: italic;
        background: linear-gradient(120deg, rgba(168, 129, 194, 0.08), rgba(168, 129, 194, 0.04));
        padding: 1px 6px;
        border-radius: 4px;
    }

    /* ── Footer ── */
    .artikel-show-footer {
        padding: 0 36px 32px;
        border-top: 1px solid #f3f4f6;
        padding-top: 24px;
        margin: 0 36px 32px;
        margin-left: 0;
        margin-right: 0;
        padding-left: 36px;
        padding-right: 36px;
    }

    .artikel-show-share-card {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8f5 100%);
        border: 1px solid rgba(168, 129, 194, 0.15);
        border-radius: 20px;
        padding: 20px;
    }

    /* ── Related Cards ── */
    .artikel-related-card {
        display: flex;
        gap: 14px;
        padding: 12px;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
        text-decoration: none;
        transition: all 0.25s ease;
        background: #fff;
    }

    .artikel-related-card:hover {
        border-color: rgba(168, 129, 194, 0.3);
        box-shadow: 0 4px 16px -4px rgba(168, 129, 194, 0.15);
        transform: translateY(-2px);
    }

    .artikel-related-thumb {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f9fafb;
    }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
        .artikel-show-wrapper {
            flex-direction: column;
        }
        .artikel-show-sidebar {
            width: 100%;
            position: static;
        }
    }

    @media (max-width: 640px) {
        .artikel-show-header {
            padding: 24px 20px 0;
        }
        .artikel-show-body {
            padding: 0 20px 24px;
        }
        .artikel-show-footer {
            padding: 0 20px 24px;
            padding-top: 20px;
            margin: 0;
            padding-left: 20px;
            padding-right: 20px;
        }
        .artikel-show-title {
            font-size: 22px;
        }
        .artikel-show-cover {
            aspect-ratio: 16 / 9;
        }
    }
</style>

<script>
    function openReportModal() {
        document.getElementById('reportModal').classList.remove('hidden');
    }
    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
    }

    function toggleBookmark(artikelId, btn) {
        const isBookmarked = btn.classList.contains('text-[#A881C2]');
        const svg = btn.querySelector('svg');
        
        // Optimistic UI update
        if (isBookmarked) {
            btn.classList.remove('text-[#A881C2]');
            btn.classList.add('text-gray-400');
            svg.setAttribute('fill', 'none');
            btn.setAttribute('title', 'Bookmark');
        } else {
            btn.classList.remove('text-gray-400');
            btn.classList.add('text-[#A881C2]');
            svg.setAttribute('fill', 'currentColor');
            btn.setAttribute('title', 'Hapus Bookmark');
        }

        fetch(`/artikel/${artikelId}/bookmark`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
        .then(data => {
            if (!data.success) {
                throw new Error('Gagal toggle bookmark');
            }
        }).catch(err => {
            // Revert UI on error
            if (isBookmarked) {
                btn.classList.add('text-[#A881C2]');
                btn.classList.remove('text-gray-400');
                svg.setAttribute('fill', 'currentColor');
                btn.setAttribute('title', 'Hapus Bookmark');
            } else {
                btn.classList.add('text-gray-400');
                btn.classList.remove('text-[#A881C2]');
                svg.setAttribute('fill', 'none');
                btn.setAttribute('title', 'Bookmark');
            }
            alert('Terjadi kesalahan saat memproses bookmark.');
        });
    }
</script>
@endpush
