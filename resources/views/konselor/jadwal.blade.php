@extends('layouts.dashboard')

@section('title', 'Jadwal Konseling - MindFlow')
@section('header', 'Jadwal Konseling')

@section('content')
@if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex justify-between items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-sm shadow-emerald-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
        <button type="button" class="text-emerald-400 hover:text-emerald-600 transition-colors" onclick="this.parentElement.style.display='none'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if(count($sesi) > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Sesi</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($sesi as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($item->user->nama_asli ?? 'P') }}&background=E2E8F0&color=475569" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $item->user->nama_asli ?? 'Tidak diketahui' }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d F Y') }}</div>
                            <div class="text-sm text-gray-500 mb-1">{{ \Carbon\Carbon::parse($item->jadwal)->format('H:i') }} WIB</div>
                            <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-50 text-[#A881C2] border border-purple-100">
                                @if($item->media_konseling == 'video_call')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Video Call
                                @elseif($item->media_konseling == 'voice_call')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Voice Call
                                @else
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Chat
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColor = match($item->status) {
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'change_requested' => 'bg-blue-100 text-blue-800',
                                    'rescheduled' => 'bg-blue-100 text-blue-800',
                                    'confirmed' => 'bg-emerald-100 text-emerald-800',
                                    'completed' => 'bg-purple-100 text-purple-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }} uppercase tracking-wide">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(in_array($item->status, ['pending', 'change_requested']))
                                <div class="flex space-x-2">
                                    <form action="{{ route('konselor.jadwal.accept', $item->sesi_konseling_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('konselor.jadwal.reject', $item->sesi_konseling_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak sesi ini?');">
                                        @csrf
                                        <button type="submit" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @elseif($item->status === 'confirmed')
                                <div class="flex space-x-2">
                                    <a href="{{ route('konseling.room', $item->sesi_konseling_id) }}" class="text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Masuk Ruangan
                                    </a>
                                    <button onclick="document.getElementById('modal-eval-{{ $item->sesi_konseling_id }}').classList.remove('hidden')" class="text-white bg-purple-500 hover:bg-purple-600 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Beri Catatan
                                    </button>
                                </div>
                            @elseif($item->status === 'completed')
                                <button onclick="document.getElementById('modal-view-{{ $item->sesi_konseling_id }}').classList.remove('hidden')" class="text-purple-600 bg-purple-50 border border-purple-200 hover:bg-purple-100 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center transition-colors">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Lihat Catatan
                                </button>
                            @else
                                <span class="text-gray-400 text-xs italic">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-10 text-center flex flex-col items-center justify-center">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Sesi</h3>
            <p class="text-gray-500">Saat ini Anda belum memiliki jadwal konseling dengan pasien manapun.</p>
        </div>
    @endif
</div>
</div>

@foreach($sesi as $item)
    @if($item->status === 'confirmed')
    <!-- Modal Beri Catatan -->
    <div id="modal-eval-{{ $item->sesi_konseling_id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-eval-{{ $item->sesi_konseling_id }}').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('konselor.jadwal.evaluasi', $item->sesi_konseling_id) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                    Catatan Evaluasi Pasca-Sesi
                                </h3>
                                <div class="mb-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <div class="text-sm text-gray-600 mb-1"><strong>Pasien:</strong> {{ $item->user->nama_asli ?? 'Tidak diketahui' }}</div>
                                    <div class="text-sm text-gray-600"><strong>Topik:</strong> {{ $item->deskripsi }}</div>
                                </div>
                                <div>
                                    <label for="catatan_konselor" class="block text-sm font-medium text-gray-700 mb-2">Catatan Konselor</label>
                                    <textarea name="catatan_konselor" id="catatan_konselor" rows="5" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-xl p-3" placeholder="Tuliskan evaluasi atau catatan untuk pasien setelah sesi selesai..." required></textarea>
                                    <p class="mt-2 text-xs text-gray-500">Catatan ini dapat dilihat oleh pasien di menu History mereka.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Simpan & Selesaikan Sesi
                        </button>
                        <button type="button" onclick="document.getElementById('modal-eval-{{ $item->sesi_konseling_id }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif($item->status === 'completed')
    <!-- Modal Lihat Catatan -->
    <div id="modal-view-{{ $item->sesi_konseling_id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-view-{{ $item->sesi_konseling_id }}').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                Catatan Evaluasi Pasca-Sesi
                            </h3>
                            <div class="mb-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div class="text-sm text-gray-600 mb-1"><strong>Pasien:</strong> {{ $item->user->nama_asli ?? 'Tidak diketahui' }}</div>
                                <div class="text-sm text-gray-600"><strong>Waktu Sesi:</strong> {{ \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d F Y, H:i') }} WIB</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Isi Catatan</label>
                                <div class="bg-purple-50 border border-purple-100 p-4 rounded-xl text-sm text-gray-800 whitespace-pre-wrap">{{ $item->catatan_konselor }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modal-view-{{ $item->sesi_konseling_id }}').classList.add('hidden')" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto sm:text-sm transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection
