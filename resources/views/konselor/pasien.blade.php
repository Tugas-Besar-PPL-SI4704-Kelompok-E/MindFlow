@extends('layouts.dashboard')

@section('title', 'Daftar Pasien - MindFlow')
@section('header', 'Daftar Pasien')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($pasien as $p)
        @if($p)
        <div class="bg-white/80 backdrop-blur-xl rounded-[32px] p-6 shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 hover:shadow-[0_15px_40px_rgba(168,129,194,0.1)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center space-x-4 mb-6">
                <img class="w-16 h-16 rounded-full border-2 border-purple-100 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($p->nama_asli ?? 'P') }}&background=E8DEFA&color=6B3FA0" alt="{{ $p->nama_asli }}">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $p->nama_asli ?? 'Nama Tidak Diketahui' }}</h3>
                    <p class="text-sm text-gray-500">{{ $p->email ?? 'Email tidak tersedia' }}</p>
                </div>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center text-gray-600 text-sm">
                    <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Pasien MindFlow</span>
                </div>
            </div>
        </div>
        @endif
    @empty
        <div class="col-span-full bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-10 text-center flex flex-col items-center justify-center min-h-[300px]">
            <div class="bg-blue-50 p-4 rounded-full mb-4 text-blue-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Pasien</h3>
            <p class="text-gray-500">Anda belum memiliki pasien yang terdaftar di jadwal konseling Anda.</p>
        </div>
    @endforelse
</div>
@endsection
