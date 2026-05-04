@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-10">
        <a href="{{ route('konseling.index') }}" class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 transition-all text-gray-600 hover:text-gray-900 group shadow-sm">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-semibold">Kembali</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Profile Detail Card -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[32px] p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 h-full">
                <div class="flex flex-col md:flex-row gap-10 items-start">
                    <!-- Avatar Area -->
                    <div class="w-full md:w-auto flex flex-col items-center gap-6">
                        <div class="relative">
                            <div class="w-44 h-44 rounded-[40px] bg-purple-50 p-1">
                                <img src="{{ $konselor->foto ? asset('storage/' . $konselor->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($konselor->nama) . '&background=A881C2&color=fff&size=180&font-size=0.35&bold=true' }}" alt="{{ $konselor->nama }}" class="w-full h-full object-cover rounded-[38px] shadow-lg">
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 border-4 border-white rounded-full shadow-md"></div>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <div class="flex gap-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">4.9 (120 Review)</span>
                        </div>
                    </div>

                    <!-- Info Area -->
                    <div class="flex-1">
                        <div class="mb-8">
                            <h2 class="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">{{ $konselor->nama }}</h2>
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-purple-50 text-[#A881C2] text-sm font-bold border border-purple-100">
                                {{ $konselor->spesialisasi }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8">
                            <div>
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#A881C2]"></span>
                                    Biografi
                                </h4>
                                <p class="text-gray-600 leading-relaxed text-[15px] font-medium">{{ $konselor->biografi }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#A881C2]"></span>
                                    Keahlian
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $konselor->keahlian) as $skill)
                                        <span class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold border border-gray-100">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Sidebar Card -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[32px] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 relative overflow-hidden h-full">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#A881C2] to-indigo-400"></div>
                
                <div class="mb-10">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-[#A881C2] flex items-center justify-center mb-6 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Booking Sesi</h3>
                    <p class="text-gray-500 text-sm mt-1">Pilih jadwal konsultasimu.</p>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="flex flex-col h-full">
                    @csrf
                    <input type="hidden" name="konselor_id" value="{{ $konselor->profil_konselor_id }}">
                    
                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Jadwal Konsultasi</label>
                            <div class="relative group">
                                <input type="text" name="jadwal" id="jadwal-picker" class="w-full bg-gray-50 border border-gray-100 rounded-[14px] px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-[13px] text-gray-700 font-bold shadow-sm transition-all cursor-pointer pr-12 placeholder-gray-400" placeholder="Pilih tanggal & waktu" required readonly>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-[#A881C2] transition-colors pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white py-3 rounded-[14px] font-bold text-[14px] shadow-lg shadow-[#A881C2]/20 transition-all duration-300 flex items-center justify-center gap-2 active:scale-[0.98]">
                            <span>Konfirmasi Reservasi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

            @php
                $contohSesi = \App\Models\SesiKonseling::with('profilKonselor')
                    ->where('profil_konselor_id', $konselor->profil_konselor_id)
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['pending', 'rescheduled'])
                    ->first();
            @endphp

            @if($contohSesi)
            <div class="mt-8 bg-white rounded-[32px] p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 animate-in fade-in slide-in-from-bottom-4 duration-700">
                <h6 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-3">
                    <div class="p-2 rounded-xl bg-amber-50 text-amber-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Sesi Aktif Kamu
                </h6>
                <div class="p-5 bg-gray-50 rounded-[20px] mb-6 border border-gray-100">
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Jadwal Terdaftar</p>
                    <p class="font-bold text-gray-900 text-base mb-3">{{ \Carbon\Carbon::parse($contohSesi->jadwal)->translatedFormat('d F Y, H:i') }}</p>
                    <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 text-[11px] font-black uppercase tracking-wider rounded-lg">
                        {{ $contohSesi->status }}
                    </span>
                </div>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('booking.edit', $contohSesi->sesi_konseling_id) }}" class="w-full text-center bg-purple-50 text-[#A881C2] hover:bg-purple-100 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300">
                        Ubah Jadwal
                    </a>
                    <form action="{{ route('booking.cancel', $contohSesi->sesi_konseling_id) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin membatalkan sesi ini?')" class="w-full bg-red-50 text-red-500 hover:bg-red-100 py-3.5 rounded-2xl text-sm font-bold transition-all duration-300">
                            Batalkan Sesi
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

@push('styles')
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.min.css">
     <style>
         .flatpickr-calendar {
             border-radius: 24px !important;
             box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
             border: 1px solid #f3f4f6 !important;
             padding: 10px !important;
         }
         .flatpickr-day.selected {
             background: #A881C2 !important;
             border-color: #A881C2 !important;
         }
         .flatpickr-confirm {
             background: #A881C2 !important;
             color: white !important;
             padding: 12px 20px !important;
             border-radius: 16px !important;
             margin: 15px auto 5px !important;
             cursor: pointer !important;
             font-weight: 800 !important;
             font-size: 13px !important;
             display: flex !important;
             justify-content: center !important;
             align-items: center !important;
             width: 90% !important;
             transition: all 0.3s !important;
             box-shadow: 0 10px 15px -3px rgba(168, 129, 194, 0.3) !important;
         }
         .flatpickr-confirm:hover {
             background: #8A64A4 !important;
             transform: translateY(-2px) !important;
             box-shadow: 0 12px 20px -3px rgba(168, 129, 194, 0.4) !important;
         }
     </style>
 @endpush

 @push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
     <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.js"></script>
     <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             flatpickr("#jadwal-picker", {
                 enableTime: true,
                 dateFormat: "Y-m-d H:i",
                 minDate: "today",
                 time_24hr: true,
                 locale: "id",
                 plugins: [
                     new confirmDatePlugin({
                         confirmText: "OK, Simpan Jadwal",
                         showAlways: true,
                         theme: "light"
                     })
                 ]
             });
         });
     </script>
 @endpush
 @endsection