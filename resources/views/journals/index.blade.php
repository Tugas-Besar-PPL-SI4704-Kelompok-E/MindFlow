@extends('layouts.app')

@section('title', 'Jurnal Refleksi Mandiri - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto pb-12">


    {{-- Jurnal Section --}}
    <div class="mb-10">
        <h3 class="text-gray-900 font-extrabold text-xl mb-4 tracking-tight">Jurnal</h3>
        <a href="{{ route('journals.create') }}" class="flex flex-col items-center justify-center w-full bg-white border border-gray-100 rounded-[24px] p-10 hover:bg-purple-50 hover:border-purple-100 transition-all shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.06)] group">
            <div class="flex items-center gap-4 mb-3">
                <svg class="w-12 h-12 text-[#A881C2] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="text-3xl font-light text-gray-400 group-hover:text-[#A881C2] transition-colors">+</span>
            </div>
            <p class="text-sm font-semibold text-gray-500 group-hover:text-[#A881C2] transition-colors">Ketuk untuk menulis jurnal</p>
        </a>
    </div>

    {{-- Riwayat Jurnal Section --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-900 font-extrabold text-xl tracking-tight">Riwayat Jurnal</h3>
            <a href="{{ route('history.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-[#A881C2] hover:bg-[#8A64A4] px-5 py-2.5 rounded-full shadow-md shadow-[#A881C2]/20 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2.5"></circle><polyline points="12 6 12 12 16 14" stroke-width="2.5"></polyline></svg>
                Lihat History Lengkap
            </a>
        </div>

        @if ($journals->isEmpty())
            <div class="bg-white rounded-[32px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-12 flex flex-col items-center justify-center min-h-[300px]">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h4 class="text-gray-900 font-bold text-lg mb-1">Jurnal Masih Kosong</h4>
                <p class="text-gray-500 text-sm text-center">Mulailah menulis luapan perasaanmu hari ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach ($journals as $journal)
                    <div class="bg-white border border-gray-100 rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.06)] transition-all p-6 flex flex-col relative group">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-[12px] font-black text-[#A881C2] uppercase tracking-widest flex items-center gap-2">
                                {{ $journal->updated_at->translatedFormat('d M Y, H:i') }}
                                @if($journal->created_at->ne($journal->updated_at))
                                    <span class="text-gray-400 font-medium tracking-normal normal-case text-[11px]">(Diedit)</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-gray-700 text-[15px] mb-5 flex-grow leading-relaxed line-clamp-3">
                            {{ $journal->content }}
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-50 mt-auto">
                            <a href="{{ route('journals.edit', $journal->journal_id) }}" class="px-4 py-1.5 bg-purple-50 text-[#A881C2] hover:bg-[#A881C2] hover:text-white rounded-lg text-sm font-bold transition-colors">Edit</a>
                            <form action="{{ route('journals.destroy', $journal->journal_id) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-sm font-bold transition-colors">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Kalender Mood Section --}}
    <div class="mb-6">
        <h3 class="text-gray-900 font-extrabold text-xl mb-4 tracking-tight">Kalender Mood</h3>
        <div class="bg-white rounded-[32px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-8 md:p-10">
            <div class="flex justify-center items-center gap-6 mb-8">
                <button class="w-10 h-10 rounded-full bg-purple-50 text-[#A881C2] hover:bg-[#A881C2] hover:text-white flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <span class="font-black text-gray-900 text-[15px] uppercase tracking-widest min-w-[120px] text-center">{{ $currentMonth }}</span>
                <button class="w-10 h-10 rounded-full bg-purple-50 text-[#A881C2] hover:bg-[#A881C2] hover:text-white flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
               @for ($i = 1; $i <= $daysInMonth; $i++)
                   @php
                       $moodClass = 'bg-[#E8DEFA] text-gray-600 hover:opacity-80';
                       if (isset($moodData[$i])) {
                           if ($moodData[$i] === 'senang') {
                               $moodClass = 'bg-emerald-300 text-emerald-900 shadow-sm shadow-emerald-200';
                           } elseif ($moodData[$i] === 'biasa') {
                               $moodClass = 'bg-yellow-300 text-yellow-900 shadow-sm shadow-yellow-200';
                           } elseif ($moodData[$i] === 'stres') {
                               $moodClass = 'bg-red-400 text-white shadow-sm shadow-red-200';
                           }
                       }
                       $isCurrentDay = (isset($currentDay) && $i == $currentDay) ? 'ring-4 ring-[#A881C2]/30 ring-offset-2 !font-black !scale-110 z-10' : '';
                   @endphp
                   <div class="w-10 h-10 md:w-11 md:h-11 flex items-center justify-center text-[14px] font-bold rounded-xl transition-all cursor-default {{ $moodClass }} {{ $isCurrentDay }}" title="Tanggal {{ $i }}">
                       {{ $i }}
                   </div>
               @endfor
            </div>
            
            <div class="flex justify-center items-center gap-6 mt-8 pt-6 border-t border-gray-50 flex-wrap">
                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-emerald-300"></div><span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Senang</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-yellow-300"></div><span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Biasa</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-red-400"></div><span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Buruk</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-[#E8DEFA]"></div><span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Kosong</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
