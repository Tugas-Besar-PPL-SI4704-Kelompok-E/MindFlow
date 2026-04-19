@extends('journals.layout')

@section('content')
<div class="max-w-3xl mx-auto glass-panel overflow-hidden">
    {{-- Header Form --}}
    <div class="bg-amber-50 border-b border-amber-100 px-8 py-5">
        <h2 class="text-xl font-bold text-amber-900">Edit Jurnal</h2>
        <p class="text-amber-700 text-sm mt-1">Mengubah atau menambahkan detail pada refleksi Anda.</p>
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

        {{-- Form action mengarah ke method update di JournalController --}}
        <form action="{{ route('journals.update', $journal->journal_id) }}" method="POST">
            @csrf 
            @method('PUT') {{-- Wajib ditambahkan karena method update di Laravel menggunakan PUT/PATCH --}}
            
            <div class="mb-6">
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Refleksi Hari Ini</label>
                {{-- Textarea lebar untuk menulis jurnal --}}
                <textarea 
                    name="content" 
                    id="content" 
                    rows="12" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors resize-y"
                    required
                >{{ old('content', $journal->content) }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Anda pertama kali menulis ini pada {{ $journal->created_at->format('d M Y') }}.</p>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                <a href="{{ route('journals.index') }}" class="px-5 py-2.5 text-gray-600 font-medium hover:text-gray-900 transition">Batal</a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg font-medium shadow-sm transition-all focus:ring focus:ring-amber-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
