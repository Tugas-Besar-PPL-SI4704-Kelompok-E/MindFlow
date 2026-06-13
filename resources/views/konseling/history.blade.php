@extends('layouts.app')

@section('title', 'Riwayat Sesi Konseling - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-gray-900 font-extrabold text-2xl tracking-tight mb-2">Riwayat Sesi Konseling</h3>
            <p class="text-gray-500 text-[15px] font-medium">Pantau riwayat sesi konseling dan catatan konselor Anda</p>
        </div>
        <a href="{{ route('konseling.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:text-[#A881C2] hover:border-purple-100 hover:bg-purple-50 transition-all shadow-sm" title="Kembali ke Konseling">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
    </div>

    <!-- Filter Form -->
    <div class="mb-6 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div class="text-sm font-semibold text-gray-700 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Filter Berdasarkan Waktu
        </div>
        <form action="{{ route('konseling.history') }}" method="GET" class="flex items-center gap-3" id="filterForm">
            <select name="range" class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block p-2.5 transition-colors" onchange="document.getElementById('filterForm').submit()">
                <option value="all" {{ $range == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                <option value="1_month" {{ $range == '1_month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                <option value="3_months" {{ $range == '3_months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="6_months" {{ $range == '6_months' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                <option value="1_year" {{ $range == '1_year' ? 'selected' : '' }}>1 Tahun Terakhir</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-[32px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">
        @if ($histories->isEmpty())
            <div class="p-12 flex flex-col items-center justify-center min-h-[300px]">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-gray-900 font-bold text-lg mb-1">Belum Ada Sesi</h4>
                <p class="text-gray-500 text-sm text-center">Tidak ada riwayat sesi konseling pada rentang waktu yang dipilih.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Konselor</th>
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Jadwal Sesi</th>
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Status Sesi</th>
                            <th class="px-8 py-5 text-[12px] font-black text-gray-500 uppercase tracking-widest whitespace-nowrap">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($histories as $history)
                            <tr class="hover:bg-purple-50/30 transition-colors group">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold overflow-hidden">
                                            @if($history->profilKonselor->foto_profil)
                                                <img src="{{ Storage::url($history->profilKonselor->foto_profil) }}" alt="{{ $history->profilKonselor->user->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($history->profilKonselor->user->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[14px] text-gray-900">{{ $history->profilKonselor->user->name }}</span>
                                            <span class="text-[12px] font-medium text-gray-500">{{ $history->profilKonselor->spesialisasi }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-[14px] text-gray-900 mb-0.5">{{ \Carbon\Carbon::parse($history->jadwal)->translatedFormat('d F Y') }}</span>
                                        <span class="text-[12px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($history->jadwal)->format('H:i') }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                                                @if($history->status === 'completed')
                                                                    <span class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 border border-red-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                                                         Selesai
                                                                     </span>
                                        @elseif($history->status === 'cancelled')
                                            <span class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 border border-red-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                                Dibatalkan
                                            </span>
                                        @elseif($history->status === 'system_cancelled')
                                            <span class="inline-flex items-center px-3 py-1 bg-orange-50 text-orange-600 border border-orange-100 rounded-lg text-[10px] font-black uppercase tracking-widest" title="Otomatis dibatalkan oleh sistem karena waktu habis">
                                                Batal Otomatis
                                            </span>
                                        @elseif($history->status === 'confirmed')
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                                Disetujui
                                            </span>
                                        @elseif($history->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-600 border border-gray-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                                {{ $history->status }}
                                            </span>
                                        @endif

                                        @if($history->status === 'completed' && $history->catatan_konselor)
                                            <button onclick="document.getElementById('modal-history-note-{{ $history->sesi_konseling_id }}').classList.remove('hidden')" class="inline-flex items-center px-3 py-1 bg-purple-50 text-purple-600 border border-purple-100 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-purple-100 transition-colors cursor-pointer">
                                                Lihat Catatan
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    @if($history->payment_status === 'paid')
                                        <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            Lunas (Paid)
                                        </span>
                                    @elseif($history->payment_status === 'waiting_verification')
                                        <span class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($history->payment_status === 'refunded')
                                        <span class="inline-flex items-center px-3 py-1 bg-red-50 text-red-600 border border-red-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-500 border border-gray-200 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            @if($history->status === 'completed' && $history->catatan_konselor)
                            <!-- Modal Lihat Catatan History -->
                            <div id="modal-history-note-{{ $history->sesi_konseling_id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-history-note-{{ $history->sesi_konseling_id }}').classList.add('hidden')"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                                        Catatan Konselor
                                                    </h3>
                                                    <div class="mb-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                        <div class="text-sm text-gray-600 mb-1"><strong>Konselor:</strong> {{ $history->profilKonselor->user->name }}</div>
                                                        <div class="text-sm text-gray-600 mb-1"><strong>Waktu Sesi:</strong> {{ \Carbon\Carbon::parse($history->jadwal)->translatedFormat('d F Y, H:i') }} WIB</div>
                                                    </div>
                                                    <div>
                                                        <div class="bg-purple-50 border border-purple-100 p-4 rounded-xl text-sm text-gray-800 whitespace-pre-wrap">{{ $history->catatan_konselor }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-100">
                                            <button type="button" onclick="document.getElementById('modal-history-note-{{ $history->sesi_konseling_id }}').classList.add('hidden')" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto sm:text-sm transition-colors">
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
