@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-10">
        <a href="{{ route('konseling.index') }}" class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 transition-all text-gray-600 hover:text-gray-900 group shadow-sm">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-semibold">Kembali</span>
        </a>
    </div>

    @if(session('success'))
        <div class="auto-dismiss-notification bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
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

    @if(session('info'))
        <div class="auto-dismiss-notification bg-blue-50 border border-blue-100 text-blue-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-sm shadow-blue-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M12 19a7 7 0 110-14 7 7 0 010 14z"></path></svg>
                </div>
                <span class="font-bold text-sm">{{ session('info') }}</span>
            </div>
            <button type="button" class="text-blue-400 hover:text-blue-600 transition-colors" onclick="this.parentElement.style.display='none'">
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
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-indigo-50 text-[#4338CA] text-sm font-bold border border-indigo-100 mt-3">
                                @if(!empty($konselor->harga_per_sesi) && $konselor->harga_per_sesi > 0)
                                    Rp{{ number_format($konselor->harga_per_sesi, 0, ',', '.') }} / sesi
                                @else
                                    Harga belum diatur
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8">
                            <div>
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#A881C2]"></span>
                                    Biografi
                                </h4>
                                <p class="text-gray-600 leading-relaxed text-[15px] font-medium">{{ $konselor->biografi ?: 'Informasi belum tersedia' }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#A881C2]"></span>
                                    Keahlian
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @if(!empty(trim($konselor->keahlian)))
                                        @foreach(explode(',', $konselor->keahlian) as $skill)
                                            <span class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold border border-gray-100">
                                                {{ trim($skill) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <p class="text-gray-500 italic text-[15px] font-medium">Informasi belum tersedia</p>
                                    @endif
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

                    @if(session('error'))
                        <div class="auto-dismiss-notification mb-5 rounded-2xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="auto-dismiss-notification mb-5 rounded-2xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Jadwal Konsultasi</label>
                            <div class="relative group">
                                <input type="text" name="jadwal" id="jadwal-picker" value="{{ old('jadwal') }}" class="w-full bg-gray-50 border @error('jadwal') border-red-500 @else border-gray-100 @enderror rounded-[14px] px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-[13px] text-gray-700 font-bold shadow-sm transition-all cursor-pointer pr-12 placeholder-gray-400" placeholder="Pilih tanggal & waktu" required readonly>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-[#A881C2] transition-colors pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('jadwal')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Media Konseling</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="media_konseling" value="video_call" class="peer sr-only" required {{ old('media_konseling') == 'video_call' ? 'checked' : '' }}>
                                    <div class="p-3 bg-gray-50 border @error('media_konseling') border-red-500 @else border-gray-100 @enderror rounded-xl hover:bg-purple-50 transition-all peer-checked:border-[#A881C2] peer-checked:bg-purple-50 peer-checked:ring-2 peer-checked:ring-[#A881C2]/30 flex flex-col items-center justify-center gap-1.5 h-full text-center">
                                        <svg class="w-6 h-6 text-gray-500 peer-checked:text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold text-gray-600 peer-checked:text-[#A881C2]">Video Call</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="media_konseling" value="voice_call" class="peer sr-only" {{ old('media_konseling') == 'voice_call' ? 'checked' : '' }}>
                                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-xl hover:bg-purple-50 transition-all peer-checked:border-[#A881C2] peer-checked:bg-purple-50 peer-checked:ring-2 peer-checked:ring-[#A881C2]/30 flex flex-col items-center justify-center gap-1.5 h-full text-center">
                                        <svg class="w-6 h-6 text-gray-500 peer-checked:text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span class="text-xs font-bold text-gray-600 peer-checked:text-[#A881C2]">Voice Call</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="media_konseling" value="chat" class="peer sr-only" {{ old('media_konseling') == 'chat' ? 'checked' : '' }}>
                                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-xl hover:bg-purple-50 transition-all peer-checked:border-[#A881C2] peer-checked:bg-purple-50 peer-checked:ring-2 peer-checked:ring-[#A881C2]/30 flex flex-col items-center justify-center gap-1.5 h-full text-center">
                                        <svg class="w-6 h-6 text-gray-500 peer-checked:text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <span class="text-xs font-bold text-gray-600 peer-checked:text-[#A881C2]">Chat</span>
                                    </div>
                                </label>
                            </div>
                            @error('media_konseling')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-2">
                            <label for="deskripsi" class="block text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Deskripsi Topik</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-100 @enderror rounded-[14px] px-4 py-3 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-[13px] text-gray-700 font-bold shadow-sm transition-all" placeholder="Jelaskan topik konsultasi Anda" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Lampirkan Jurnal (Opsional)</label>
                            <p class="text-xs text-gray-500 ml-1 mb-2">Konselor dapat membaca jurnal yang kamu pilih sebagai referensi tambahan.</p>
                            @if(isset($userJournals) && $userJournals->count() > 0)
                                <div class="relative">
                                    <select name="journals[]" id="journals" multiple class="w-full text-sm">
                                        @foreach($userJournals as $journal)
                                            <option value="{{ $journal->journal_id }}" {{ (is_array(old('journals')) && in_array($journal->journal_id, old('journals'))) ? 'selected' : '' }}>
                                                {{ $journal->created_at->translatedFormat('d M Y') }} — {{ Str::limit(trim(strip_tags($journal->content)), 40) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="p-3 bg-gray-50 border border-gray-100 rounded-[14px] text-center">
                                    <p class="text-xs font-medium text-gray-500">Kamu belum pernah menulis jurnal. <br> <a href="{{ route('journals.index') }}" class="text-[#A881C2] hover:underline font-bold">Tulis jurnal pertamamu</a></p>
                                </div>
                            @endif
                            @error('journals')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Metode Pembayaran</label>
                            <div class="grid grid-cols-1 gap-3">
                                <label class="relative cursor-pointer block">
                                    <input type="radio" name="payment_method" value="transfer" class="peer sr-only" required {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                                    <div class="relative p-4 pl-5 rounded-[18px] border @error('payment_method') border-red-500 @else border-gray-100 @enderror bg-gray-50 hover:bg-purple-50 transition-all duration-300 ease-out transform hover:-translate-y-[0.5px] peer-checked:border-[#A881C2] peer-checked:bg-purple-50 peer-checked:ring-2 peer-checked:ring-[#A881C2]/30 peer-checked:shadow-[0_0_0_1px_rgba(168,129,194,0.3)]">
                                        <span class="absolute inset-y-0 left-0 w-1.5 rounded-r-full bg-[#A881C2] opacity-0 transition-all duration-300 peer-checked:opacity-100"></span>
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex w-10 h-10 rounded-2xl bg-white text-[#A881C2] items-center justify-center shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                                            </span>
                                            <div>
                                                <p class="font-bold text-gray-900 peer-checked:text-[#3B076E]">Transfer Bank</p>
                                                <p class="text-xs text-gray-500 peer-checked:text-[#4338CA]">Kirim bukti pembayaran ke admin.</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer block">
                                    <input type="radio" name="payment_method" value="e-wallet" class="peer sr-only" {{ old('payment_method') == 'e-wallet' ? 'checked' : '' }}>
                                    <div class="relative p-4 pl-5 rounded-[18px] border @error('payment_method') border-red-500 @else border-gray-100 @enderror bg-gray-50 hover:bg-purple-50 transition-all duration-300 ease-out transform hover:-translate-y-[0.5px] peer-checked:border-[#A881C2] peer-checked:bg-purple-50 peer-checked:ring-2 peer-checked:ring-[#A881C2]/30 peer-checked:shadow-[0_0_0_1px_rgba(168,129,194,0.3)]">
                                        <span class="absolute inset-y-0 left-0 w-1.5 rounded-r-full bg-[#A881C2] opacity-0 transition-all duration-300 peer-checked:opacity-100"></span>
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex w-10 h-10 rounded-2xl bg-white text-[#A881C2] items-center justify-center shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 11h8m-8 4h5"></path></svg>
                                            </span>
                                            <div>
                                                <p class="font-bold text-gray-900 peer-checked:text-[#3B076E]">E-Wallet</p>
                                                <p class="text-xs text-gray-500 peer-checked:text-[#4338CA]">Bayar cepat melalui e-wallet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="rounded-[22px] bg-gray-50 border border-gray-100 p-4">
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Pembayaran</p>
                            <p class="text-2xl font-extrabold text-gray-900">
                                @if(!empty($konselor->harga_per_sesi) && $konselor->harga_per_sesi > 0)
                                    Rp{{ number_format($konselor->harga_per_sesi, 0, ',', '.') }}
                                @else
                                    Gratis / belum ditentukan
                                @endif
                            </p>
                        </div>

                        <button type="submit" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white py-3 rounded-[14px] font-bold text-[14px] shadow-lg shadow-[#A881C2]/20 transition-all duration-300 flex items-center justify-center gap-2 active:scale-[0.98]">
                            <span>Konfirmasi Pembayaran</span>
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
                    ->whereIn('status', ['pending', 'rescheduled', 'confirmed', 'change_requested'])
                    ->first();
            @endphp

            @if($contohSesi)
            <div class="mt-8 bg-white rounded-[32px] p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 animate-in fade-in slide-in-from-bottom-4 duration-700">
                @if($contohSesi->payment_status === 'refunded')
                    <div class="mb-6 rounded-[28px] bg-emerald-50 border border-emerald-100 p-5 text-emerald-900">
                        <div class="flex items-start gap-3">
                            <div class="w-11 h-11 rounded-3xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2 0 .62.31 1.16.78 1.48L12 16l1.22-4.52A1.99 1.99 0 0014 10c0-1.1-.9-2-2-2zm0 10v2m0-16V2m4 4l1.5-1.5m-11 0L8 4m8 12l1.5 1.5M5.5 17.5L7 19.5"></path></svg>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm font-bold">Pembayaran telah dikembalikan</p>
                                <p class="text-sm text-gray-600">Pembayaran untuk sesi ini sedang diproses kembali ke metode Anda.</p>
                            </div>
                        </div>
                    </div>
                @endif
                <h6 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-3">
                    <div class="p-2 rounded-xl bg-amber-50 text-amber-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    Sesi Aktif Kamu
                </h6>
                <div class="p-5 bg-gray-50 rounded-[20px] mb-6 border border-gray-100 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-2 h-full bg-[#A881C2]"></div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Jadwal Terdaftar</p>
                    <p class="font-bold text-gray-900 text-base mb-3">{{ \Carbon\Carbon::parse($contohSesi->jadwal)->translatedFormat('d F Y, H:i') }}</p>
                    
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 text-[11px] font-black uppercase tracking-wider rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            {{ $contohSesi->status }}
                        </span>
                        
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-[#A881C2] text-[11px] font-black uppercase tracking-wider rounded-lg border border-purple-100">
                            @if($contohSesi->media_konseling == 'video_call')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Video Call
                            @elseif($contohSesi->media_konseling == 'voice_call')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                Voice Call
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Chat
                            @endif
                        </span>
                    </div>
                    <div class="mt-4 text-sm text-gray-600 space-y-2">
                        <p class="font-bold">Metode Pembayaran:</p>
                        <p>{{ ucfirst(str_replace('-', ' ', $contohSesi->payment_method ?? 'Belum dipilih')) }}</p>
                        <p class="font-bold">Status Pembayaran:</p>
                        <p>{{ ucfirst($contohSesi->payment_status ?? 'Belum bayar') }}</p>
                    </div>
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
             z-index: 99999 !important;
             position: absolute !important;
             pointer-events: auto !important;
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
         
         /* Choices.js Custom Theme */
         .choices__inner {
             background-color: #f9fafb !important;
             border: 1px solid #f3f4f6 !important;
             border-radius: 14px !important;
             padding: 6px 12px !important;
             box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
         }
         .choices.is-focused .choices__inner {
             background-color: #ffffff !important;
             border-color: #A881C2 !important;
             box-shadow: 0 0 0 4px rgba(168, 129, 194, 0.1) !important;
         }
         .choices__list--multiple .choices__item {
             background-color: #A881C2 !important;
             border: 1px solid #8A64A4 !important;
             border-radius: 8px !important;
             max-width: 100% !important;
             white-space: nowrap !important;
             overflow: hidden !important;
             text-overflow: ellipsis !important;
             display: inline-block !important;
             padding-right: 28px !important; /* Spasi untuk tombol silang */
             position: relative !important;
         }
         .choices__list--multiple .choices__item .choices__button {
             position: absolute !important;
             right: 4px !important;
             top: 50% !important;
             transform: translateY(-50%) !important;
             margin: 0 !important;
             border-left: none !important;
             display: block !important;
         }
         .choices__list--dropdown {
             border-radius: 14px !important;
             border: 1px solid #f3f4f6 !important;
             box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
             margin-top: 5px !important;
             z-index: 50 !important;
         }
         .choices__list--dropdown .choices__item--selectable.is-highlighted {
             background-color: #f3e8f8 !important;
             color: #A881C2 !important;
         }
     </style>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
 @endpush

 @push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
     <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.js"></script>
     <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const bookedSlots = @json($bookedSchedules ?? []);

             flatpickr("#jadwal-picker", {
                 appendTo: document.body,
                 enableTime: true,
                 dateFormat: "Y-m-d H:i",
                 minDate: new Date(new Date().getTime() + 3 * 60 * 60 * 1000),
                 time_24hr: true,
                 locale: "id",
                 clickOpens: true,
                 disable: bookedSlots,
                 defaultDate: "{{ old('jadwal') }}",
                 plugins: [
                     new confirmDatePlugin({
                         confirmText: "OK, Simpan Jadwal",
                         showAlways: true,
                         theme: "light"
                     })
                 ]
             });

             @if(isset($contohSesi) && $contohSesi->status == 'pending')
             // Trik simulasi real-time: cek auto-cancel setelah sesi pending sudah lewat batas waktu
             setTimeout(function() {
                 fetch("{{ route('booking.checkExpired') }}", {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     body: JSON.stringify({})
                 })
                 .then(function(response) {
                     return response.json();
                 })
                 .then(function(data) {
                     if (data.cancelled) {
                         window.location.reload();
                     }
                 })
                 .catch(function(error) {
                     console.error('Auto-cancel request gagal:', error);
                 });
             }, {{ env('AUTO_CANCEL_SECONDS', 3) * 1000 }});
             @endif

             // Inisialisasi Choices.js untuk multi-select dropdown jurnal
             const journalsSelect = document.getElementById('journals');
             if (journalsSelect) {
                 new Choices(journalsSelect, {
                     removeItemButton: true,
                     searchEnabled: false,
                     itemSelectText: '',
                     placeholderValue: 'Klik untuk memilih jurnal...',
                     noResultsText: 'Tidak ada jurnal',
                     noChoicesText: 'Semua jurnal telah dipilih',
                 });
             }
         });
     </script>
 @endpush
 @endsection