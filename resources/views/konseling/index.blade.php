@extends('layouts.app')

@section('content')
@php
    $isSpesialisasiActive = ($selectedSpesialisasi ?? request('spesialisasi', 'semua')) !== 'semua';
    $isKetersediaanActive = ($availability ?? request('ketersediaan', 'semua')) !== 'semua';
@endphp
    <!-- Header Page Section -->
    <div class="mb-8">
        <div class="text-left mb-6">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-3">Pilih Konselor</h2>
            <p class="text-gray-500 text-base max-w-lg">Temukan tenaga profesional yang tepat untuk membantu perjalanan kesehatan mentalmu.</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-[32px] p-3 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-white/50 mx-auto w-full sticky top-6 z-40 transition-all hover:shadow-[0_15px_40px_rgb(0,0,0,0.08)] hover:-translate-y-1">
            <form action="{{ route('konseling.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                
                <!-- Search Bar -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        value="{{ old('search', $search ?? request('search')) }}"
                        placeholder="Cari nama konselor atau keahlian..."
                        class="w-full h-full bg-gray-50/50 border border-transparent rounded-[24px] py-4 pl-12 pr-5 text-sm text-gray-700 focus:bg-white focus:border-[#A881C2] focus:ring-4 focus:ring-[#A881C2]/10 transition-all outline-none"
                    />
                </div>

                <!-- Kategori Spesialisasi -->
                <div class="lg:w-60 relative shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 {{ $isSpesialisasiActive ? 'text-[#A881C2]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <select name="spesialisasi" onchange="this.form.submit()" class="appearance-none w-full h-full border border-transparent py-4 pl-11 pr-10 rounded-[24px] text-sm focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] transition-all cursor-pointer {{ $isSpesialisasiActive ? 'bg-purple-50 text-[#8A64A4] font-bold' : 'bg-gray-50/50 text-gray-700' }}">
                        <option value="semua">Semua Kategori</option>
                        @foreach($spesialisasiList as $item)
                            <option value="{{ $item }}" {{ ($selectedSpesialisasi ?? request('spesialisasi')) == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 {{ $isSpesialisasiActive ? 'text-[#A881C2]' : 'text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Ketersediaan -->
                <div class="lg:w-48 relative shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 {{ $isKetersediaanActive ? 'text-[#A881C2]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <select name="ketersediaan" onchange="this.form.submit()" class="appearance-none w-full h-full border border-transparent py-4 pl-11 pr-10 rounded-[24px] text-sm focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] transition-all cursor-pointer {{ $isKetersediaanActive ? 'bg-purple-50 text-[#8A64A4] font-bold' : 'bg-gray-50/50 text-gray-700' }}">
                        <option value="semua">Semua Waktu</option>
                        <option value="tersedia" {{ ($availability ?? request('ketersediaan')) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 {{ $isKetersediaanActive ? 'text-[#A881C2]' : 'text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button type="submit" class="bg-[#A881C2] text-white px-10 py-4 rounded-[24px] text-sm font-bold hover:bg-[#8A64A4] transition-colors shadow-lg shadow-purple-100 shrink-0">
                    Cari
                </button>
            </form>
        </div>

        @if($search || $selectedSpesialisasi || $availability)
        <div class="flex justify-center mt-5 pb-6">
            <a href="{{ route('konseling.index') }}" class="inline-flex items-center gap-2 text-sm text-[#A881C2] font-semibold hover:text-[#8A64A4] bg-purple-50 hover:bg-purple-100 px-5 py-2.5 rounded-full transition-colors border border-purple-100 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Hapus Filter Pencarian
            </a>
        </div>
        @else
        <div class="pb-6"></div>
        @endif
    </div>

    @if($konselors->isEmpty())
        <!-- Empty State -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[40px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-20 flex flex-col items-center justify-center min-h-[450px]">
            <div class="w-32 h-32 bg-purple-50 rounded-full flex items-center justify-center mb-8">
                <svg class="w-16 h-16 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h4 class="text-gray-900 font-bold text-2xl mb-3">Konselor Tidak Ditemukan</h4>
            <p class="text-gray-500 text-base text-center max-w-xs leading-relaxed font-medium">Maaf, saat ini belum ada konselor yang tersedia untuk kategori tersebut.</p>
            <a href="{{ route('konseling.index') }}" class="mt-10 px-8 py-3.5 bg-[#A881C2] text-white rounded-2xl font-bold hover:bg-[#8A64A4] transition-all shadow-lg shadow-purple-100">Lihat Semua Konselor</a>
        </div>
    @else
        <!-- Counselor Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
            @foreach($konselors as $k)
            <div class="bg-white/80 backdrop-blur-xl rounded-[32px] overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 flex flex-col hover:-translate-y-2 hover:shadow-[0_25px_50px_rgba(168,129,194,0.15)] transition-all duration-500 group">
                
                <!-- Card Cover with Mesh Gradient -->
                <div class="h-28 bg-white/50 backdrop-blur-md relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-200/50 rounded-full mix-blend-multiply filter blur-2xl opacity-70 group-hover:scale-125 group-hover:opacity-100 transition-all duration-700"></div>
                    <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-200/50 rounded-full mix-blend-multiply filter blur-2xl opacity-70 group-hover:scale-150 group-hover:opacity-100 transition-all duration-700 delay-100"></div>
                </div>
                
                <div class="px-8 pb-10 flex-1 flex flex-col items-center text-center -mt-14 relative z-10">
                    <!-- Avatar -->
                    <div class="mb-5 relative">
                        <div class="w-28 h-28 p-1 bg-white rounded-[32px] shadow-xl">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=A881C2&color=fff&size=120&font-size=0.35&bold=true" alt="{{ $k->nama }}" class="w-full h-full object-cover rounded-[28px]">
                        </div>
                        <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full shadow-sm"></div>
                    </div>

                    <h4 class="font-bold text-gray-900 text-xl mb-1 group-hover:text-[#A881C2] transition-colors duration-300 leading-tight">{{ $k->nama }}</h4>
                    <div class="px-4 py-1.5 rounded-full bg-purple-50 text-[#A881C2] text-[11px] font-black uppercase tracking-wider mb-8 border border-purple-100/50">
                        {{ $k->spesialisasi }}
                    </div>
                    
                    <div class="mt-auto w-full space-y-4">
                        <div class="bg-gray-50 rounded-2xl p-4 flex flex-col items-center justify-center gap-1 group-hover:bg-purple-50 transition-colors duration-300 min-h-[70px]">
                            @if($k->counselorSchedules->isNotEmpty())
                                @foreach($k->counselorSchedules->take(2) as $jadwal)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-[11px] text-gray-600 font-bold uppercase tracking-wider">{{ ucfirst($jadwal->hari) }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                                    </div>
                                @endforeach
                                @if($k->counselorSchedules->count() > 2)
                                    <span class="text-[9px] text-gray-400 italic">...dan jadwal lainnya</span>
                                @endif
                            @else
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-[11px] text-gray-400 font-bold italic uppercase tracking-wider">Jadwal belum diatur</span>
                                </div>
                            @endif
                        </div>
                        <div class="mt-3 text-center">
                            @if(!empty($k->harga_per_sesi) && $k->harga_per_sesi > 0)
                                <span class="inline-block px-4 py-2 bg-purple-50 rounded-full">
                                    <span class="text-[#1E1B4B] font-extrabold text-lg">Rp{{ number_format($k->harga_per_sesi, 0, ',', '.') }}</span>
                                    <span class="text-[#8A64A4] font-medium text-xs ml-1">/ sesi</span>
                                </span>
                            @else
                                <span class="inline-block px-4 py-2 bg-gray-50 text-gray-400 rounded-full">Harga belum diatur</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('konseling.show', $k->profil_konselor_id) }}" class="flex items-center justify-center gap-2 bg-white hover:bg-[#A881C2] text-[#A881C2] hover:text-white w-full py-4 rounded-2xl text-sm font-black transition-all duration-300 border border-purple-100 hover:border-transparent shadow-sm hover:shadow-xl hover:shadow-purple-200/50 active:scale-[0.98] group/btn">
                            Pilih Sesi
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5-5 5M6 12h12"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Typewriter Effect for Search Bar Placeholder
        const searchInput = document.getElementById('searchInput');
        if (searchInput && !searchInput.value) {
            const placeholders = [
                "Cari nama konselor...",
                "Cari 'Konseling Akademik'...",
                "Cari 'Kecemasan'...",
                "Cari 'Dr. Rania'...",
                "Cari 'Karir'..."
            ];
            
            let currentIndex = 0;
            let currentText = '';
            let isDeleting = false;
            let typingSpeed = 100;
            
            function typeWriter() {
                const fullText = placeholders[currentIndex];
                
                if (isDeleting) {
                    currentText = fullText.substring(0, currentText.length - 1);
                    typingSpeed = 50;
                } else {
                    currentText = fullText.substring(0, currentText.length + 1);
                    typingSpeed = 100;
                }
                
                searchInput.setAttribute('placeholder', currentText);
                
                if (!isDeleting && currentText === fullText) {
                    typingSpeed = 2000; // Pause at end
                    isDeleting = true;
                } else if (isDeleting && currentText === '') {
                    isDeleting = false;
                    currentIndex = (currentIndex + 1) % placeholders.length;
                    typingSpeed = 500; // Pause before new word
                }
                
                setTimeout(typeWriter, typingSpeed);
            }
            
            // Start typewriter after a short delay
            setTimeout(typeWriter, 1000);
            
            // Stop when user focuses the input
            searchInput.addEventListener('focus', function() {
                this.setAttribute('placeholder', 'Ketik kata kunci di sini...');
            });
        }
    });
</script>
@endsection