@extends('layouts.app')

@section('title', 'Tulis Jurnal Baru - MindFlow')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-gray-900 font-extrabold text-2xl tracking-tight mb-2">Tulis Jurnal Baru</h3>
            <p class="text-gray-500 text-[15px] font-medium">Bagaimana perasaanmu hari ini? Tuliskan apa yang memicu stres atau kebahagiaanmu.</p>
        </div>
        <a href="{{ route('journals.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:text-[#A881C2] hover:border-purple-100 hover:bg-purple-50 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-8 md:p-10">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl mb-8 shadow-sm">
                <ul class="list-disc list-inside text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('journals.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="content" class="block text-[15px] font-bold text-gray-900 mb-3">Refleksi Hari Ini</label>
                <textarea
                    name="content"
                    id="content"
                    class="w-full min-h-[250px] bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-[15px] text-gray-700 font-medium transition-all placeholder-gray-400 resize-y"
                    placeholder="Saya merasa sedikit tertekan saat bekerja karena..."
                    required
                >{{ old('content') }}</textarea>
                <p class="mt-3 text-sm font-medium text-gray-400 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tuliskan cerita Anda sebebas mungkin. Data ini dilindungi dan hanya Anda yang dapat melihatnya.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                <a href="{{ route('journals.index') }}" class="px-6 py-3 rounded-2xl text-[14px] font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors">Batal</a>
                <button type="submit" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-8 py-3 rounded-2xl font-bold text-[14px] shadow-md shadow-[#A881C2]/20 transition-all active:scale-95 tracking-wide">Simpan Jurnal</button>
            </div>
        </form>
    </div>
</div>
@endsection
