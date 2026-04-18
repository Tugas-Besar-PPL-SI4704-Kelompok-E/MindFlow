@extends('journals.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">History Jurnal Anda</h2>
        <p class="text-gray-600 text-sm mt-1">Lacak dan lihat kembali refleksi perjalanan mental Anda.</p>
    </div>
    <a href="{{ route('journals.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm transition-all focus:ring focus:ring-indigo-300">
        + Tulis Jurnal Baru
    </a>
</div>

{{-- Flash message jika berhasil melakukan operasi (create/update/delete) --}}
@if (session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

{{-- Cek apakah ada jurnal --}}
@if ($journals->isEmpty())
    <div class="glass-panel p-10 text-center flex flex-col items-center justify-center">
        <div class="text-gray-400 mb-3">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada jurnal</h3>
        <p class="text-gray-500">Anda belum menulis jurnal apapun. Yuk mulai tulis refleksi hari ini!</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($journals as $journal)
            <div class="glass-panel p-6 flex flex-col">
                {{-- Tanggal pembuatan jurnal dengan format yang mudah dibaca --}}
                <div class="text-xs font-semibold text-indigo-600 mb-2 uppercase tracking-wide">
                    {{ $journal->updated_at->translatedFormat('d F Y \p\u\k\u\l H:i') }}
                    @if($journal->created_at->ne($journal->updated_at))
                        <span class="ml-1 text-gray-400 normal-case font-normal">(Diedit)</span>
                    @endif
                </div>
                
                {{-- Potongan snippet konten agar tidak terlalu panjang di card --}}
                <div class="text-gray-700 mb-6 flex-grow line-clamp-4">
                    {{ Str::limit($journal->content, 150, '...') }}
                </div>
                
                {{-- Aksi Edit dan Hapus --}}
                <div class="flex justify-end gap-2 border-t pt-4 mt-auto">
                    {{-- Tombol Edit --}}
                    <a href="{{ route('journals.edit', $journal->journal_id) }}" class="text-sm px-3 py-1.5 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-md transition font-medium">Edit</a>
                    
                    {{-- Form Hapus (menggunakan method DELETE) --}}
                    <form action="{{ route('journals.destroy', $journal->journal_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm px-3 py-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition font-medium">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
