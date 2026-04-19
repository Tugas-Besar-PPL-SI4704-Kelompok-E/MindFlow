@extends('journals.layout')

@section('content')
<div class="w-full h-full overflow-y-auto px-6 py-8 md:px-12 lg:px-[60px] pb-20">
    <!-- Kotak Form Jurnal -->
    <div class="w-full max-w-[1000px] mx-auto border border-gray-200 rounded-[14px] bg-white shadow-sm overflow-hidden mb-10">
        {{-- Header Form --}}
        <div class="bg-[#F3E8FF] border-b border-purple-100 px-8 py-6">
            <h2 class="text-[20px] font-bold text-[#111827]">Tulis Jurnal Baru</h2>
            <p class="text-purple-700 text-[13px] font-medium mt-1">Bagaimana perasaanmu hari ini? Tuliskan apa yang memicu stres atau kebahagiaanmu.</p>
        </div>

        <div class="p-8">
            {{-- Menampilkan pesan error validasi --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('journals.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="content" class="block text-[14px] font-bold text-[#111827] mb-2">Refleksi Hari Ini</label>
                    <textarea 
                        name="content" 
                        id="content" 
                        class="w-full h-[300px] px-5 py-4 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition shadow-sm resize-y text-gray-700"
                        placeholder="Saya merasa sedikit tertekan saat bekerja karena..."
                        required
                    >{{ old('content') }}</textarea>
                    <p class="text-[12px] text-gray-400 font-medium mt-2">Tuliskan cerita Anda sebebas mungkin. Data ini dilindungi dan hanya Anda yang dapat melihatnya.</p>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('journals.index') }}" class="px-5 py-2.5 text-gray-500 text-[14px] font-semibold hover:text-gray-800 transition">Batal</a>
                    <button type="submit" class="bg-[#5B21B6] hover:bg-purple-800 text-white px-6 py-2.5 rounded-lg text-[14px] font-semibold shadow-sm transition-all focus:outline-none focus:ring focus:ring-purple-300">
                        Simpan Jurnal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
