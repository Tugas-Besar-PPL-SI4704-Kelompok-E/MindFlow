@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('konseling.show', $sesi->profil_konselor_id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#A881C2] font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Profil Konselor
        </a>
    </div>

    <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-[#8B5CF6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Ubah Jadwal Konseling
        </h2>

        <div class="mb-8 p-4 bg-[#F3E8FF] rounded-xl">
            <p class="text-sm text-[#554172] font-medium">
                Konselor: <span class="font-bold">{{ $sesi->profilKonselor->nama }}</span>
            </p>
            <p class="text-sm text-[#554172] mt-1">
                Jadwal Saat Ini: <span class="font-bold">{{ $sesi->jadwal }}</span>
            </p>
        </div>

        <form action="{{ route('booking.update', $sesi->sesi_konseling_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-3">Jadwal Konsultasi Baru</label>
                <input type="datetime-local" name="jadwal" value="{{ old('jadwal', \Carbon\Carbon::parse($sesi->jadwal)->format('Y-m-d\TH:i')) }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#A881C2] focus:border-[#A881C2] text-sm text-gray-700 shadow-sm transition-shadow" required>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-[#A881C2] hover:bg-[#8A64A4] text-white px-6 py-3 rounded-xl font-bold shadow-sm transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('konseling.show', $sesi->profil_konselor_id) }}" class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-bold shadow-sm transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
