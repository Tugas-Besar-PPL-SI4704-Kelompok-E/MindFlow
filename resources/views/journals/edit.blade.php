@extends('journals.layout')

@section('content')
<div class="w-full h-full flex flex-col px-6 py-6 md:px-12 lg:px-[60px]">
    <!-- Kotak Form Jurnal -->
    <div class="w-full max-w-[1000px] mx-auto border border-gray-200 rounded-[14px] bg-white shadow-sm flex flex-col h-full overflow-hidden">
        {{-- Header Form --}}
        <div class="bg-[#F3E8FF] border-b border-purple-100 px-8 py-5 flex-shrink-0">
            <h2 class="text-[20px] font-bold text-[#111827]">Edit Jurnal</h2>
            <p class="text-purple-700 text-[13px] font-medium mt-1">Mengubah atau menambahkan detail pada refleksi Anda.</p>
        </div>

        <div class="px-8 py-6 flex-grow flex flex-col">
            {{-- Menampilkan pesan error validasi --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-4 text-sm flex-shrink-0">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('journals.update', $journal->journal_id) }}" method="POST" class="flex flex-col h-full">
                @csrf
                @method('PUT')
                
                <div class="flex-grow flex flex-col">
                    <label for="content" class="block text-[14px] font-bold text-[#111827] mb-2 flex-shrink-0">Refleksi Hari Ini</label>
                    <textarea 
                        name="content" 
                        id="content" 
                        class="w-full flex-grow px-5 py-4 border border-gray-200 rounded-lg text-[14px] focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 transition shadow-sm resize-none text-gray-700"
                        required
                    >{{ old('content', $journal->content) }}</textarea>
                    <p class="text-[12px] text-gray-400 font-medium mt-2 flex-shrink-0">Anda pertama kali menulis ini pada {{ $journal->created_at->format('d M Y') }}.</p>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 flex-shrink-0">
                    <a href="{{ route('journals.index') }}" class="px-5 py-2.5 text-gray-500 text-[14px] font-semibold hover:text-gray-800 transition">Batal</a>
                    <button type="submit" class="bg-[#5B21B6] hover:bg-purple-800 text-white px-6 py-2.5 rounded-lg text-[14px] font-semibold shadow-sm transition-all focus:outline-none focus:ring focus:ring-purple-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
