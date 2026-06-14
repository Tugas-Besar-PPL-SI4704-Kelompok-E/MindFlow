@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Artikel Disimpan</h2>
        <p class="text-gray-500 text-sm font-medium">Daftar artikel kesehatan mental, tips, dan motivasi yang telah Anda simpan.</p>
    </div>
    @auth
    <a href="{{ route('artikel.index') }}" class="flex items-center justify-center gap-2 bg-white hover:bg-purple-50 text-[#A881C2] border border-purple-100 px-5 py-2.5 rounded-xl font-bold text-sm shadow-[0_2px_8px_-2px_rgba(168,129,194,0.15)] transition-all group">
        <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Semua Artikel
    </a>
    @endauth
</div>

{{-- Search & Filter Bar --}}
<div class="bg-white rounded-[24px] p-5 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 mb-8">
    <form action="{{ route('artikel.bookmarks') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        {{-- Search Input --}}
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input 
                type="text" 
                name="search" 
                id="artikel-search"
                value="{{ request('search') }}" 
                placeholder="Cari artikel..." 
                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#A881C2]/30 focus:border-[#A881C2] focus:bg-white transition-all"
            >
        </div>
        
        {{-- Filter Dropdown --}}
        <div class="relative">
            <select 
                name="kategori" 
                id="artikel-filter"
                class="appearance-none w-full sm:w-48 px-4 py-3 pr-10 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#A881C2]/30 focus:border-[#A881C2] focus:bg-white transition-all cursor-pointer"
                onchange="this.form.submit()"
            >
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
        
        {{-- Search Button --}}
        <button type="submit" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-md shadow-[#A881C2]/20 transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Cari
        </button>
        
        @if(request('search') || request('kategori'))
            <a href="{{ route('artikel.bookmarks') }}" class="flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-500 rounded-2xl text-sm font-bold transition-all">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Reset
            </a>
        @endif
    </form>
</div>

{{-- Active Filters Badge --}}
@if(request('search') || request('kategori'))
<div class="flex flex-wrap gap-2 mb-6">
    @if(request('search'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-[#A881C2] rounded-xl text-xs font-bold border border-purple-100">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            "{{ request('search') }}"
        </span>
    @endif
    @if(request('kategori'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-[#A881C2] rounded-xl text-xs font-bold border border-purple-100">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            {{ request('kategori') }}
        </span>
    @endif
    <span class="inline-flex items-center px-3 py-1.5 text-gray-400 text-xs font-medium">
        {{ $artikels->total() }} artikel ditemukan
    </span>
</div>
@endif

{{-- Articles Grid --}}
@if($artikels->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @foreach($artikels as $artikel)
        <article 
            class="group bg-white rounded-[24px] overflow-hidden shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_12px_40px_-8px_rgba(168,129,194,0.15)] hover:border-purple-100 transition-all duration-300 flex flex-col cursor-pointer" 
            id="artikel-card-{{ $artikel->artikel_id }}"
            onclick="openArtikelModal({{ $artikel->artikel_id }})"
        >
            {{-- Cover Image --}}
            <div class="relative overflow-hidden aspect-[16/10] bg-gradient-to-br from-purple-50 to-indigo-50">
                @if($artikel->gambar_cover)
                    <img src="{{ asset('storage/' . $artikel->gambar_cover) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    {{-- Default illustration when no cover --}}
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-white/60 backdrop-blur-sm flex items-center justify-center shadow-sm">
                                <svg class="w-8 h-8 text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h10"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Kategori Badge --}}
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
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 {{ $katColors }} rounded-xl text-[10px] font-black uppercase tracking-wider backdrop-blur-sm shadow-sm">
                            {{ $artikel->kategori }}
                        </span>
                    </div>
                @endif

                {{-- Bookmark Button --}}
                @auth
                <div class="absolute top-4 right-4" onclick="event.stopPropagation()">
                    <button 
                        type="button" 
                        onclick="toggleBookmark({{ $artikel->artikel_id }}, this)"
                        class="w-9 h-9 flex items-center justify-center transition-all group/bm {{ $artikel->isBookmarkedBy(Auth::id()) ? 'text-[#A881C2]' : 'text-gray-400 hover:text-[#A881C2] drop-shadow-sm' }}"
                        title="{{ $artikel->isBookmarkedBy(Auth::id()) ? 'Hapus Bookmark' : 'Bookmark' }}"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="{{ $artikel->isBookmarkedBy(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                </div>
                @endauth
            </div>
            
            {{-- Content --}}
            <div class="p-5 flex-1 flex flex-col">
                {{-- Date --}}
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        {{ $artikel->created_at->translatedFormat('d M Y') }}
                    </span>
                </div>
                
                {{-- Title --}}
                <h3 class="text-[15px] font-bold text-gray-900 leading-snug mb-2 group-hover:text-[#A881C2] transition-colors line-clamp-2">
                    {{ $artikel->judul }}
                </h3>
                
                {{-- Excerpt --}}
                <p class="text-gray-500 text-[13px] leading-relaxed mb-4 line-clamp-3 flex-1">
                    {{ Str::limit(strip_tags($artikel->konten), 120) }}
                </p>
                
                {{-- Footer: Author + Read More --}}
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($artikel->admin->nama_asli ?? 'Admin') }}&background=E8DEFA&color=6B3FA0&size=28&bold=true&font-size=0.45" alt="Author" class="w-6 h-6 rounded-full">
                        <span class="text-[11px] font-semibold text-gray-500">{{ $artikel->admin->nama_asli ?? 'Admin' }}</span>
                    </div>
                    <span class="text-[12px] font-bold text-[#A881C2] group-hover:translate-x-0.5 transition-transform inline-flex items-center gap-1">
                        Baca
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </div>
        </article>
    @endforeach
</div>

{{-- Artikel Detail Modal --}}
<div id="artikelModal" class="artikel-modal-overlay" onclick="closeArtikelModal(event)">
    <div class="artikel-modal-container" onclick="event.stopPropagation()">
        {{-- Close Button --}}
        <button type="button" class="artikel-modal-close" onclick="closeArtikelModal()" id="btn-close-artikel-modal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Modal Image --}}
        <div class="artikel-modal-image-wrapper">
            <div id="artikelModalImage" class="artikel-modal-image"></div>
            <div id="artikelModalKategori" class="artikel-modal-kategori"></div>
        </div>

        {{-- Modal Content --}}
        <div class="artikel-modal-content">
            {{-- Date & Author --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span id="artikelModalDate" class="text-[11px] font-bold text-gray-400 uppercase tracking-wider"></span>
                </div>
                <span class="text-gray-200">•</span>
                <div class="flex items-center gap-1.5">
                    <img id="artikelModalAuthorAvatar" src="" alt="Author" class="w-5 h-5 rounded-full">
                    <span id="artikelModalAuthor" class="text-[11px] font-semibold text-gray-500"></span>
                </div>
            </div>

            {{-- Title --}}
            <h2 id="artikelModalTitle" class="text-xl font-bold text-gray-900 leading-snug mb-4"></h2>

            {{-- Divider --}}
            <div class="w-12 h-1 bg-gradient-to-r from-[#A881C2] to-[#C4A8E0] rounded-full mb-5"></div>

            {{-- Description --}}
            <div id="artikelModalDeskripsi" class="artikel-modal-deskripsi text-gray-600 text-[14px] leading-relaxed"></div>

            {{-- Read Button --}}
            <div class="mt-6 pt-5 border-t border-gray-100">
                <a href="#" id="artikelModalReadBtn" class="w-full bg-gradient-to-r from-[#A881C2] to-[#9B6FB8] hover:from-[#8A64A4] hover:to-[#7D5599] text-white px-6 py-3.5 rounded-2xl font-bold text-sm shadow-lg shadow-[#A881C2]/25 transition-all active:scale-[0.98] flex items-center justify-center gap-2 no-underline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Baca Selengkapnya
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Artikel Data for Modal --}}
@php
    $artikelModalData = [];
    foreach ($artikels as $a) {
        $artikelModalData[$a->artikel_id] = [
            'id' => $a->artikel_id,
            'judul' => $a->judul,
            'konten' => strip_tags($a->konten),
            'gambar_cover' => $a->gambar_cover ? asset('storage/' . $a->gambar_cover) : null,
            'kategori' => $a->kategori,
            'tanggal' => $a->created_at->translatedFormat('d M Y'),
            'author' => $a->admin->nama_asli ?? 'Admin',
            'url' => route('artikel.show', $a->artikel_id),
        ];
    }
@endphp
<script>
    const artikelData = @json($artikelModalData);
</script>

{{-- Pagination --}}
@if($artikels->hasPages())
<div class="flex justify-center">
    <div class="bg-white rounded-2xl px-2 py-2 shadow-sm border border-gray-100 inline-flex items-center gap-1">
        {{-- Previous --}}
        @if($artikels->onFirstPage())
            <span class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-300 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $artikels->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-500 hover:bg-purple-50 hover:text-[#A881C2] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach($artikels->getUrlRange(1, $artikels->lastPage()) as $page => $url)
            @if($page == $artikels->currentPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#A881C2] text-white text-sm font-bold shadow-sm shadow-[#A881C2]/20">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-500 hover:bg-purple-50 hover:text-[#A881C2] text-sm font-bold transition-all">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($artikels->hasMorePages())
            <a href="{{ $artikels->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-500 hover:bg-purple-50 hover:text-[#A881C2] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-300 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </div>
</div>
@endif

@else
{{-- Empty State --}}
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-12 flex flex-col items-center justify-center min-h-[400px]">
    <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mb-6">
        <svg class="w-12 h-12 text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h10"/>
        </svg>
    </div>
    <h4 class="text-gray-900 font-bold text-xl mb-2">
        @if(request('search') || request('kategori'))
            Artikel Tidak Ditemukan
        @else
            Belum Ada Bookmark
        @endif
    </h4>
    <p class="text-gray-500 text-[15px] text-center max-w-xs leading-relaxed">
        @if(request('search') || request('kategori'))
            Coba ubah kata kunci pencarian atau filter kategori untuk menemukan artikel bookmark yang Anda cari.
        @else
            Anda belum membookmark artikel apa pun. Mulai simpan artikel menarik untuk dibaca lagi nanti!
        @endif
    </p>
    @if(request('search') || request('kategori'))
        <a href="{{ route('artikel.bookmarks') }}" class="mt-6 bg-[#A881C2] hover:bg-[#8A64A4] text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-md shadow-[#A881C2]/20 transition-all active:scale-95">
            Lihat Semua Bookmark
        </a>
    @else
        <a href="{{ route('artikel.index') }}" class="mt-6 bg-[#A881C2] hover:bg-[#8A64A4] text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-md shadow-[#A881C2]/20 transition-all active:scale-95">
            Jelajahi Artikel
        </a>
    @endif
</div>
@endif

@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── Artikel Modal ── */
    .artikel-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 10, 25, 0.55);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .artikel-modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .artikel-modal-container {
        background: #fff;
        border-radius: 28px;
        width: 100%;
        max-width: 768px; /* Lebih lebar */
        max-height: 85vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 
            0 24px 80px -12px rgba(168, 129, 194, 0.25),
            0 8px 24px -4px rgba(0, 0, 0, 0.1);
        transform: translateY(30px) scale(0.96);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .artikel-modal-overlay.show .artikel-modal-container {
        transform: translateY(0) scale(1);
    }

    .artikel-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: none;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .artikel-modal-close:hover {
        background: #fff;
        color: #111827;
        transform: rotate(90deg);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .artikel-modal-image-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        flex-shrink: 0;
        background: linear-gradient(135deg, #f3e8f5 0%, #e8e0f0 100%);
    }

    .artikel-modal-image {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 0.5s ease;
    }

    .artikel-modal-container:hover .artikel-modal-image {
        transform: scale(1.03);
    }

    .artikel-modal-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .artikel-modal-kategori {
        position: absolute;
        bottom: 16px;
        left: 16px;
    }

    .artikel-modal-kategori-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .artikel-modal-content {
        padding: 28px;
        overflow-y: auto;
        flex: 1;
    }

    .artikel-modal-deskripsi {
        /* Hilangkan max-height dan overflow agar panjang tanpa inner scroll */
        padding-right: 4px;
    }

    .artikel-modal-deskripsi::-webkit-scrollbar {
        width: 4px;
    }
    .artikel-modal-deskripsi::-webkit-scrollbar-track {
        background: transparent;
    }
    .artikel-modal-deskripsi::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 4px;
    }
    .artikel-modal-deskripsi::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }

    /* Prevent body scroll when modal is open */
    body.artikel-modal-open .main-content {
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    function openArtikelModal(artikelId) {
        const artikel = artikelData[artikelId];
        if (!artikel) return;

        const modal = document.getElementById('artikelModal');
        const imageEl = document.getElementById('artikelModalImage');
        const kategoriEl = document.getElementById('artikelModalKategori');
        const titleEl = document.getElementById('artikelModalTitle');
        const dateEl = document.getElementById('artikelModalDate');
        const authorEl = document.getElementById('artikelModalAuthor');
        const authorAvatarEl = document.getElementById('artikelModalAuthorAvatar');
        const deskripsiEl = document.getElementById('artikelModalDeskripsi');

        // Set image
        if (artikel.gambar_cover) {
            imageEl.style.backgroundImage = `url('${artikel.gambar_cover}')`;
            imageEl.innerHTML = '';
            imageEl.classList.remove('artikel-modal-image-placeholder');
        } else {
            imageEl.style.backgroundImage = 'none';
            imageEl.classList.add('artikel-modal-image-placeholder');
            imageEl.innerHTML = `
                <div class="text-center">
                    <div style="width:64px;height:64px;margin:0 auto 12px;border-radius:16px;background:rgba(255,255,255,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
                        <svg style="width:32px;height:32px;color:#A881C2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h10"/>
                        </svg>
                    </div>
                </div>`;
        }

        // Set kategori badge
        if (artikel.kategori) {
            const colorMap = {
                'Kesehatan Mental': 'background:rgba(16,185,129,0.9);color:#fff',
                'Tips & Trik': 'background:rgba(59,130,246,0.9);color:#fff',
                'Motivasi': 'background:rgba(245,158,11,0.9);color:#fff',
                'Edukasi': 'background:rgba(139,92,246,0.9);color:#fff',
            };
            const badgeStyle = colorMap[artikel.kategori] || 'background:rgba(107,114,128,0.9);color:#fff';
            kategoriEl.innerHTML = `<span class="artikel-modal-kategori-badge" style="${badgeStyle}">${artikel.kategori}</span>`;
        } else {
            kategoriEl.innerHTML = '';
        }

        // Set text content
        titleEl.textContent = artikel.judul;
        dateEl.textContent = artikel.tanggal;
        authorEl.textContent = artikel.author;
        authorAvatarEl.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(artikel.author)}&background=E8DEFA&color=6B3FA0&size=28&bold=true&font-size=0.45`;

        // Set read button link
        const readBtn = document.getElementById('artikelModalReadBtn');
        readBtn.href = artikel.url;

        // Set description (show more content in modal)
        const maxLen = 500;
        let deskripsi = artikel.konten;
        if (deskripsi.length > maxLen) {
            deskripsi = deskripsi.substring(0, maxLen) + '...';
        }
        deskripsiEl.textContent = deskripsi;

        // Show modal
        modal.classList.add('show');
        document.body.classList.add('artikel-modal-open');

        // Focus trap - close on Escape
        document.addEventListener('keydown', handleArtikelModalEsc);
    }

    function closeArtikelModal(event) {
        // If called from overlay click, only close if clicking the overlay itself
        if (event && event.target !== event.currentTarget) return;
        
        const modal = document.getElementById('artikelModal');
        modal.classList.remove('show');
        document.body.classList.remove('artikel-modal-open');
        document.removeEventListener('keydown', handleArtikelModalEsc);
    }

    function handleArtikelModalEsc(e) {
        if (e.key === 'Escape') {
            closeArtikelModal();
        }
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
