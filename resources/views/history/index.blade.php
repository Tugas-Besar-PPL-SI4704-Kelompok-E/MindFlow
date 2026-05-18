@extends('layouts.app')

@section('title', 'History Lengkap - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-gray-900 font-extrabold text-2xl tracking-tight mb-2">History Lengkap</h3>
            <p class="text-gray-500 text-[15px] font-medium">Daftar riwayat semua aktivitas Anda di MindFlow</p>
        </div>
        <a href="{{ route('journals.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:text-[#A881C2] hover:border-purple-100 hover:bg-purple-50 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
        @if ($histories->isEmpty())
            <div class="p-12 flex flex-col items-center justify-center min-h-[300px]">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-gray-900 font-bold text-lg mb-1">Belum Ada Aktivitas</h4>
                <p class="text-gray-500 text-sm text-center">Riwayat aktivitas Anda akan muncul di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Jenis Aktivitas</th>
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Tanggal & Waktu</th>
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($histories as $history)
                            <tr class="hover:bg-purple-50/30 transition-colors group">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        @php
                                            $iconBgClass = match($history->color) {
                                                'emerald' => 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-100',
                                                'blue' => 'bg-blue-50 text-blue-500 group-hover:bg-blue-100',
                                                'indigo' => 'bg-indigo-50 text-indigo-500 group-hover:bg-indigo-100',
                                                'purple' => 'bg-purple-50 text-purple-500 group-hover:bg-purple-100',
                                                default => 'bg-gray-50 text-gray-500 group-hover:bg-gray-100'
                                            };
                                        @endphp
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors {{ $iconBgClass }}">
                                            @if($history->icon === 'zap')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            @elseif($history->icon === 'search')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            @elseif($history->icon === 'users')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            @endif
                                        </div>
                                        <span class="font-bold text-[14px] text-gray-900">{{ $history->type }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-[14px] text-gray-900 mb-0.5">{{ \Carbon\Carbon::parse($history->date)->translatedFormat('d F Y') }}</span>
                                        <span class="text-[12px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($history->date)->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            {{ $history->status }}
                                        </span>
                                        @if(isset($history->note) && $history->note)
                                            <button onclick="document.getElementById('modal-history-note-{{ $history->sesi_id }}').classList.remove('hidden')" class="inline-flex items-center px-3 py-1 bg-purple-50 text-purple-600 border border-purple-100 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-purple-100 transition-colors cursor-pointer">
                                                Lihat Catatan
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if(isset($history->note) && $history->note)
                            <!-- Modal Lihat Catatan History -->
                            <div id="modal-history-note-{{ $history->sesi_id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-history-note-{{ $history->sesi_id }}').classList.add('hidden')"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                                        Catatan Konselor
                                                    </h3>
                                                    <div class="mb-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                        <div class="text-sm text-gray-600 mb-1"><strong>Waktu Sesi:</strong> {{ \Carbon\Carbon::parse($history->date)->translatedFormat('d F Y, H:i') }} WIB</div>
                                                    </div>
                                                    <div>
                                                        <div class="bg-purple-50 border border-purple-100 p-4 rounded-xl text-sm text-gray-800 whitespace-pre-wrap">{{ $history->note }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-100">
                                            <button type="button" onclick="document.getElementById('modal-history-note-{{ $history->sesi_id }}').classList.add('hidden')" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto sm:text-sm transition-colors">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
