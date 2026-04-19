@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <h3 class="font-bold text-gray-900 text-[18px]">Konselor</h3>
    
    <!-- PBI 27: Filter Spesialisasi -->
    <form action="{{ route('konseling.index') }}" method="GET" class="flex items-center gap-2">
        <div class="relative">
            <select name="spesialisasi" class="appearance-none bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#A881C2] focus:border-[#A881C2] shadow-sm text-sm font-medium cursor-pointer transition-shadow">
                <option value="">-- Semua Spesialisasi --</option>
                <option value="Kesehatan Mental" {{ request('spesialisasi') == 'Kesehatan Mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                <option value="Konseling Akademik" {{ request('spesialisasi') == 'Konseling Akademik' ? 'selected' : '' }}>Konseling Akademik</option>
                <option value="Karir" {{ request('spesialisasi') == 'Karir' ? 'selected' : '' }}>Karir</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
        <button type="submit" class="bg-[#F3E8FF] text-[#8B5CF6] hover:bg-[#E9D5FF] px-5 py-2 rounded-xl text-sm font-bold transition-colors shadow-sm">
            Filter
        </button>
    </form>
</div>

@if($konselors->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-[20px] shadow-sm border border-gray-200 p-12 flex flex-col items-center justify-center min-h-[450px] relative">
        <div class="absolute top-6 right-6">
            <button class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-6 py-2 rounded-full text-sm font-semibold transition shadow-sm">
                Buat Janji
            </button>
        </div>
        
        <!-- Cloud illustration placeholder -->
        <img src="https://ui-avatars.com/api/?name=Cloud&background=fff&color=cbd5e1&size=160&font-size=0.33" alt="Empty" class="w-40 h-40 mb-6 opacity-60">
        <p class="text-gray-500 text-[13px] font-medium">Sepertinya kamu belum menjadwalkan sesi. Mulai bicara dengan ahli hari ini.</p>
    </div>
@else
    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($konselors as $k)
        <div class="bg-white rounded-[24px] overflow-hidden shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-gray-100 flex flex-col hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 relative group">
            
            <!-- Top Gradient Background -->
            <div class="h-[140px] bg-gradient-to-b from-[#987FC5] to-[#B5A1D6] relative">
            </div>
            
            <!-- Avatar overlapping the background -->
            <div class="absolute top-[60px] left-1/2 transform -translate-x-1/2 z-10">
                <!-- Using UI Avatars to mimic the real photos since we don't have them -->
                <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=random&color=fff&size=120" alt="{{ $k->nama }}" class="w-[120px] h-[120px] object-cover rounded-xl shadow-lg border-4 border-white bg-white">
            </div>

            <!-- Card Content -->
            <div class="pt-[50px] pb-6 px-6 flex-1 flex flex-col items-center text-center">
                <h4 class="font-bold text-gray-900 text-[17px] mb-1 group-hover:text-[#A881C2] transition-colors">{{ $k->nama }}</h4>
                <p class="text-[13px] text-gray-500 mb-6 font-medium">{{ $k->spesialisasi }}</p>
                
                <div class="mt-auto w-full flex items-center justify-between gap-2">
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-[10px] text-gray-500 font-medium whitespace-nowrap bg-gray-50 flex-1 text-left truncate">
                        Senin - Rabu, 09.00 - 12.00
                    </div>
                    <a href="{{ route('konseling.show', $k->id) }}" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-5 py-2 rounded-lg text-[13px] font-semibold transition shadow-sm whitespace-nowrap">
                        Pilih Sesi
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection