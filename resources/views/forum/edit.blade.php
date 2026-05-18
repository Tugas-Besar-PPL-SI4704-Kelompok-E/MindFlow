@extends('layouts.app')

@section('content')

    <div class="mb-10">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-4 group">
            <div class="w-11 h-11 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm group-hover:shadow group-hover:border-purple-200 transition-all text-gray-500 group-hover:text-[#A881C2]">
                <svg class="w-6 h-6 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <span class="text-[#4B5563] font-extrabold text-xl">Kembali</span>
        </a>
    </div>

<div class="bg-white rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100">
    <div class="mb-6 pb-4 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-900">Edit Postingan</h2>
    </div>

    <form action="{{ route('forum.update', $thread->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <textarea name="content" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-[15px] text-gray-800 font-medium transition-all resize-y min-h-[150px]" required>{{ old('content', $thread->content) }}</textarea>
            @error('content')
                <div class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="flex justify-end gap-3">
            <a href="{{ route('forum.index') }}" class="px-6 py-2.5 rounded-full font-bold text-[14px] text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all">Batal</a>
            <button type="submit" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-8 py-2.5 rounded-full font-bold text-[14px] shadow-md shadow-[#A881C2]/20 transition-all active:scale-95 tracking-wide">Simpan Perubahan</button>
        </div>
    </form>
</div>

@endsection
