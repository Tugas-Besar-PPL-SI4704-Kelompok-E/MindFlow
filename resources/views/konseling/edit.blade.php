@extends('layouts.app')

@section('content')
    <div class="mb-10">
        <a href="{{ route('konseling.show', $sesi->profil_konselor_id) }}" class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 transition-all text-gray-600 hover:text-gray-900 group shadow-sm">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-semibold">Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-[40px] p-10 md:p-12 shadow-[0_4px_25px_-4px_rgba(0,0,0,0.05)] border border-gray-100 animate-in fade-in zoom-in duration-700">
        <div class="flex items-center gap-5 mb-10">
            <div class="p-4 rounded-2xl bg-purple-50 text-[#A881C2] shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight leading-tight">Ubah Jadwal Konseling</h2>
                <p class="text-gray-500 text-base mt-1">Atur ulang waktu pertemuanmu dengan konselor.</p>
            </div>
        </div>

        <div class="mb-12 p-8 bg-purple-50/50 rounded-[32px] border border-purple-100 flex items-start gap-6">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-md border border-purple-100 flex items-center justify-center flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($sesi->profilKonselor->nama) }}&background=A881C2&color=fff&size=60&bold=true" class="w-14 h-14 rounded-xl">
            </div>
            <div>
                <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Konselor Terpilih</p>
                <p class="text-gray-900 font-bold text-xl mb-2">{{ $sesi->profilKonselor->nama }}</p>
                <p class="text-base text-gray-500 font-medium">Jadwal Saat Ini: <span class="text-[#A881C2] font-bold">{{ \Carbon\Carbon::parse($sesi->jadwal)->translatedFormat('d F Y, H:i') }}</span></p>
            </div>
        </div>

        <form action="{{ route('booking.update', $sesi->sesi_konseling_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-12">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 ml-1">Jadwal Konsultasi Baru</label>
                <div class="relative">
                    <input type="datetime-local" name="jadwal" value="{{ old('jadwal', \Carbon\Carbon::parse($sesi->jadwal)->format('Y-m-d\TH:i')) }}" class="w-full bg-gray-50 border border-gray-200 rounded-[24px] px-6 py-5 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-base text-gray-700 font-bold shadow-sm transition-all" required>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="flex-[2] bg-[#A881C2] hover:bg-[#8A64A4] text-white px-8 py-5 rounded-[24px] font-extrabold shadow-xl shadow-purple-100 transition-all duration-300 flex items-center justify-center gap-3 active:scale-[0.98] text-base">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('konseling.show', $sesi->profil_konselor_id) }}" class="flex-1 px-8 py-5 border-2 border-gray-100 text-gray-500 hover:bg-gray-50 hover:text-gray-700 hover:border-gray-200 rounded-[24px] font-bold transition-all duration-300 text-center text-base">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
