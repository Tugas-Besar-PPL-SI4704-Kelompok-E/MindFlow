@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Artikel</h2>
    <p class="text-gray-500 text-sm font-medium">Temukan artikel seputar kesehatan mental, tips, dan motivasi untuk keseharianmu.</p>
</div>

{{-- Search & Filter Bar --}}
<div class="bg-white rounded-[24px] p-5 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 mb-8">
    <form action="{{ route('artikel.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
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
            <a href="{{ route('artikel.index') }}" class="flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-500 rounded-2xl text-sm font-bold transition-all">
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
        <article class="group bg-white rounded-[24px] overflow-hidden shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_12px_40px_-8px_rgba(168,129,194,0.15)] hover:border-purple-100 transition-all duration-300 flex flex-col" id="artikel-card-{{ $artikel->artikel_id }}">
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
                <div class="absolute top-4 right-4">
                    <button 
                        type="button" 
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white/80 backdrop-blur-sm shadow-sm hover:bg-white transition-all group/bm {{ $artikel->isBookmarkedBy(Auth::id()) ? 'text-[#A881C2]' : 'text-gray-400 hover:text-[#A881C2]' }}"
                        title="{{ $artikel->isBookmarkedBy(Auth::id()) ? 'Hapus Bookmark' : 'Bookmark' }}"
                    >
                        <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="{{ $artikel->isBookmarkedBy(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
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
            Belum Ada Artikel
        @endif
    </h4>
    <p class="text-gray-500 text-[15px] text-center max-w-xs leading-relaxed">
        @if(request('search') || request('kategori'))
            Coba ubah kata kunci pencarian atau filter kategori untuk menemukan artikel yang Anda cari.
        @else
            Artikel seputar kesehatan mental akan segera hadir. Nantikan update terbaru!
        @endif
    </p>
    @if(request('search') || request('kategori'))
        <a href="{{ route('artikel.index') }}" class="mt-6 bg-[#A881C2] hover:bg-[#8A64A4] text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-md shadow-[#A881C2]/20 transition-all active:scale-95">
            Lihat Semua Artikel
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
</style>
@endpush
