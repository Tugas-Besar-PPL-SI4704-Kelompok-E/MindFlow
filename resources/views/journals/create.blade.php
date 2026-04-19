@extends('journals.layout')

@section('content')
<div class="max-w-3xl mx-auto glass-panel overflow-hidden">
    {{-- Header Form --}}
    <div class="bg-indigo-50 border-b border-indigo-100 px-8 py-5">
        <h2 class="text-xl font-bold text-indigo-900">Tulis Jurnal Baru</h2>
        <p class="text-indigo-700 text-sm mt-1">Bagaimana perasaanmu hari ini? Tuliskan apa yang memicu stres atau kebahagiaanmu.</p>
    </div>

    <div class="p-8">
        {{-- Menampilkan pesan error jika ada validasi yang gagal --}}
        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form action mengarah ke method store di JournalController --}}
        <form action="{{ route('journals.store') }}" method="POST">
            @csrf {{-- Wajib di Laravel untuk keamanan proteksi dari CSRF attack --}}
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Refleksi Hari Ini</label>
                {{-- Textarea lebar untuk menulis jurnal --}}
                <textarea 
                    name="content" 
                    id="content" 
                    rows="12" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-y"
                    placeholder="Saya merasa sedikit tertekan saat bekerja karena..."
                    required
                >{{ old('content') }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Tuliskan cerita Anda sebebas mungkin. Data ini dilindungi dan hanya Anda yang dapat melihatnya.</p>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                <a href="{{ route('journals.index') }}" class="px-5 py-2.5 text-gray-600 font-medium hover:text-gray-900 transition">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm transition-all focus:ring focus:ring-indigo-300">
                    Simpan Jurnal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
