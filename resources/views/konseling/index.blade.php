@extends('layouts.app')

@section('content')
    <!-- Header Page Section -->
    <div class="grid gap-8 xl:grid-cols-[1.4fr_0.9fr] items-start mb-12">
        <div class="space-y-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Pilih Konselor</h2>
                <p class="text-gray-500 text-base max-w-md">Temukan tenaga profesional yang tepat untuk membantu perjalanan kesehatan mentalmu.</p>
            </div>

            <form action="{{ route('konseling.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ old('search', $search ?? request('search')) }}"
                        placeholder="Cari nama konselor, keahlian, atau gejala..."
                        class="w-full border border-gray-200 rounded-2xl py-4 px-5 pr-28 text-sm text-gray-700 shadow-sm focus:border-[#A881C2] focus:ring-4 focus:ring-[#A881C2]/10 transition-all"
                    />
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-[#4F46E5] text-white px-6 rounded-2xl text-sm font-semibold hover:bg-[#4338CA] transition-colors">Cari</button>
                </div>

                <div class="flex flex-wrap gap-3 items-center">
                    <span class="text-sm text-gray-500">Gunakan filter di samping untuk mempersempit hasil pencarian.</span>
                    @if($search || $selectedSpesialisasi || $availability)
                        <a href="{{ route('konseling.index') }}" class="inline-flex items-center gap-2 text-[#A881C2] font-semibold hover:text-[#7F56D9]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <aside class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <h3 class="text-lg font-bold text-gray-900 mb-5">FILTER PENCARIAN</h3>
            <form action="{{ route('konseling.index') }}" method="GET" class="space-y-5">
                <input type="hidden" name="search" value="{{ $search ?? request('search') }}">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Spesialisasi</label>
                    <div class="relative">
                        <select name="spesialisasi" class="appearance-none w-full bg-white border border-gray-200 py-3.5 pl-5 pr-12 rounded-2xl text-sm text-gray-700 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] transition-all">
                            <option value="semua">Semua Kategori</option>
                            @foreach($spesialisasiList as $item)
                                <option value="{{ $item }}" {{ ($selectedSpesialisasi ?? request('spesialisasi')) == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ketersediaan</label>
                    <div class="relative">
                        <select name="ketersediaan" class="appearance-none w-full bg-white border border-gray-200 py-3.5 pl-5 pr-12 rounded-2xl text-sm text-gray-700 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] transition-all">
                            <option value="semua">Semua Status</option>
                            <option value="tersedia" {{ ($availability ?? request('ketersediaan')) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#A881C2] text-white py-3 rounded-2xl font-semibold hover:bg-[#8A64A4] transition-colors">Terapkan Filter</button>
            </form>
        </aside>
    </div>

    @if($konselors->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-[40px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 p-20 flex flex-col items-center justify-center min-h-[450px]">
            <div class="w-32 h-32 bg-purple-50 rounded-full flex items-center justify-center mb-8">
                <svg class="w-16 h-16 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h4 class="text-gray-900 font-bold text-2xl mb-3">Konselor Tidak Ditemukan</h4>
            <p class="text-gray-500 text-base text-center max-w-xs leading-relaxed font-medium">Maaf, saat ini belum ada konselor yang tersedia untuk kategori tersebut.</p>
            <a href="{{ route('konseling.index') }}" class="mt-10 px-8 py-3.5 bg-[#A881C2] text-white rounded-2xl font-bold hover:bg-[#8A64A4] transition-all shadow-lg shadow-purple-100">Lihat Semua Konselor</a>
        </div>
    @else
        <!-- Counselor Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
            @foreach($konselors as $k)
            <div class="bg-white rounded-[32px] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-50 flex flex-col hover:shadow-[0_20px_50px_rgba(168,129,194,0.12)] transition-all duration-500 group">
                
                <!-- Card Cover -->
                <div class="h-28 bg-gradient-to-br from-purple-50 to-indigo-50 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-100/50 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="absolute -left-4 -bottom-10 w-20 h-20 bg-indigo-100/50 rounded-full group-hover:scale-150 transition-transform duration-700 delay-100"></div>
                </div>
                
                <div class="px-8 pb-10 flex-1 flex flex-col items-center text-center -mt-14 relative z-10">
                    <!-- Avatar -->
                    <div class="mb-5 relative">
                        <div class="w-28 h-28 p-1 bg-white rounded-[32px] shadow-xl">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=A881C2&color=fff&size=120&font-size=0.35&bold=true" alt="{{ $k->nama }}" class="w-full h-full object-cover rounded-[28px]">
                        </div>
                        <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full shadow-sm"></div>
                    </div>

                    <h4 class="font-bold text-gray-900 text-xl mb-1 group-hover:text-[#A881C2] transition-colors duration-300 leading-tight">{{ $k->nama }}</h4>
                    <div class="px-4 py-1.5 rounded-full bg-purple-50 text-[#A881C2] text-[11px] font-black uppercase tracking-wider mb-8 border border-purple-100/50">
                        {{ $k->spesialisasi }}
                    </div>
                    
                    <div class="mt-auto w-full space-y-4">
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center justify-center gap-3 group-hover:bg-purple-50 transition-colors duration-300">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs text-gray-600 font-bold">Senin - Rabu, 09.00 - 12.00</span>
                        </div>
                        <div class="mt-3 text-center">
                            @if(!empty($k->harga_per_sesi) && $k->harga_per_sesi > 0)
                                <span class="inline-block px-4 py-2 bg-purple-50 text-[#6B21A8] font-bold rounded-full">Rp{{ number_format($k->harga_per_sesi, 0, ',', '.') }} / sesi</span>
                            @else
                                <span class="inline-block px-4 py-2 bg-gray-50 text-gray-400 rounded-full">Harga belum diatur</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('konseling.show', $k->profil_konselor_id) }}" class="flex items-center justify-center gap-2 bg-white hover:bg-[#A881C2] text-[#A881C2] hover:text-white w-full py-4 rounded-2xl text-sm font-black transition-all duration-300 border-2 border-purple-100 hover:border-[#A881C2] shadow-sm hover:shadow-lg hover:shadow-purple-100 active:scale-[0.98]">
                            Pilih Sesi
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5-5 5M6 12h12"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

@endsection