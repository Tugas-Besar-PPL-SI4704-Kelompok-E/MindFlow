@extends('layouts.dashboard')

@section('title', 'Dashboard Konselor - MindFlow')
@section('header', 'Ruang Kerja Dokter')

@section('content')
<div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-10 mb-10 flex items-center justify-between transition-all hover:shadow-[0_15px_40px_rgba(168,129,194,0.1)] hover:-translate-y-1">
    <div>
        <h3 class="text-[26px] font-extrabold text-gray-900 mb-3 tracking-tight">Selamat datang, Dokter!</h3>
        <p class="text-gray-500 text-sm leading-relaxed max-w-2xl">
            Ini adalah dashboard khusus konselor. Anda dapat mengelola jadwal konseling, melihat daftar pasien, dan merespon thread di forum MindFlow.
            <br>Saat Anda memposting atau merespon di forum, badge khusus <strong class="text-[#A881C2]">Dokter</strong> akan otomatis ditambahkan ke nama Anda.
        </p>
    </div>
    <div class="hidden lg:block text-[#A881C2]/30">
        <svg class="w-32 h-32 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
    <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-8 flex flex-col justify-between transition-all hover:shadow-[0_15px_40px_rgba(168,129,194,0.1)] hover:-translate-y-1">
        <div class="text-gray-500 text-[13px] font-bold uppercase tracking-widest mb-4">Sesi Konseling Hari Ini</div>
        <div class="flex items-center justify-between">
            <div class="text-[48px] font-black text-gray-900 leading-none">{{ $sesiHariIni ?? 0 }}</div>
            <div class="p-4 bg-purple-50 text-[#A881C2] rounded-2xl border border-purple-100 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-8 flex flex-col justify-between transition-all hover:shadow-[0_15px_40px_rgba(168,129,194,0.1)] hover:-translate-y-1">
        <div class="text-gray-500 text-[13px] font-bold uppercase tracking-widest mb-4">Pasien Aktif</div>
        <div class="flex items-center justify-between">
            <div class="text-[48px] font-black text-blue-600 leading-none">{{ $pasienAktif ?? 0 }}</div>
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl border border-blue-100 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-8 flex justify-center mt-10">
    <a href="{{ route('forum.index') }}" class="flex items-center px-10 py-4 bg-[#A881C2] text-white font-bold rounded-2xl hover:bg-[#8A64A4] transition-all shadow-lg shadow-purple-200 active:scale-95 group">
        Menuju Forum MindFlow
        <svg class="w-5 h-5 ml-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
    </a>
</div>
@endsection
