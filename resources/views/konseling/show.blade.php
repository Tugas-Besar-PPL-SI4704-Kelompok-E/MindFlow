@extends('layouts.app')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('konseling.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#A881C2] font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Konselor
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-8 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="text-green-500 hover:text-green-700 focus:outline-none" onclick="this.parentElement.style.display='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profil Detail -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-8">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($konselor->nama) }}&background=random&color=fff&size=120" alt="{{ $konselor->nama }}" class="w-32 h-32 object-cover rounded-2xl shadow-sm border border-gray-100">
                </div>
                
                <!-- Info -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $konselor->nama }}</h2>
                    <span class="inline-block bg-[#F3E8FF] text-[#8B5CF6] px-4 py-1.5 rounded-full text-sm font-bold mb-6">
                        {{ $konselor->spesialisasi }}
                    </span>

                    <div class="space-y-6">
                        <div>
                            <h5 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Biografi</h5>
                            <p class="text-gray-600 leading-relaxed text-[15px]">{{ $konselor->biografi }}</p>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Keahlian</h5>
                            <p class="text-gray-600 leading-relaxed text-[15px]">{{ $konselor->keahlian }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-[#E9D5FF] relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#987FC5] to-[#B5A1D6]"></div>
                
                <h5 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Booking Sesi
                </h5>
                
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="konselor_id" value="{{ $konselor->id }}">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal Konsultasi</label>
                        <input type="datetime-local" name="jadwal" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#A881C2] focus:border-[#A881C2] text-sm text-gray-700 shadow-sm transition-shadow" required>
                    </div>

                    <button type="submit" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white px-4 py-3 rounded-xl font-bold shadow-sm transition-colors flex items-center justify-center gap-2">
                        Konfirmasi Reservasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection