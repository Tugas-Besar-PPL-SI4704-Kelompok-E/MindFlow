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

    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-xl mb-8 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('info') }}</span>
            </div>
            <button type="button" class="text-blue-500 hover:text-blue-700 focus:outline-none" onclick="this.parentElement.style.display='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-8 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" class="text-red-500 hover:text-red-700 focus:outline-none" onclick="this.parentElement.style.display='none'">
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
                    <input type="hidden" name="konselor_id" value="{{ $konselor->profil_konselor_id }}">
                    
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

            @php
                $contohSesi = \App\Models\SesiKonseling::with('profilKonselor')
                    ->where('profil_konselor_id', $konselor->profil_konselor_id)
                    ->whereIn('status', ['pending', 'rescheduled'])
                    ->first();
            @endphp

            @if($contohSesi)
            <div class="mt-6 bg-white rounded-[24px] p-6 shadow-sm border border-gray-100">
                <h6 class="font-bold text-gray-900 mb-4">Sesi Aktif Kamu</h6>
                <div class="p-4 bg-gray-50 rounded-xl mb-4">
                    <p class="text-sm text-gray-600">Jadwal</p>
                    <p class="font-bold text-gray-900">{{ $contohSesi->jadwal }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">
                        {{ ucfirst($contohSesi->status) }}
                    </span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('booking.edit', $contohSesi->sesi_konseling_id) }}" class="flex-1 text-center bg-[#F3E8FF] text-[#8B5CF6] hover:bg-[#E9D5FF] px-4 py-2 rounded-xl text-sm font-bold transition-colors">
                        Ubah Jadwal
                    </a>
                    <form action="{{ route('booking.cancel', $contohSesi->sesi_konseling_id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin membatalkan sesi ini?')" class="w-full bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-sm font-bold transition-colors">
                            Batalkan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection