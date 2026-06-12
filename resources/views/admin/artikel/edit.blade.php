@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.artikel.index') }}" class="text-gray-400 hover:text-[#A881C2] transition-colors p-1.5 rounded-lg hover:bg-gray-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
    </a>
    <h2 class="text-xl font-bold text-gray-800">Edit Artikel</h2>
</div>

<form action="{{ route('admin.artikel.update', $artikel->artikel_id) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
    @csrf
    @method('PUT')
    <div class="p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Judul --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Judul Artikel *</label>
                <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" placeholder="Tuliskan judul artikel yang menarik..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-700" required>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Kategori / Tema</label>
                <select name="kategori" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($availableKategoris as $kat)
                        <option value="{{ $kat }}" {{ old('kategori', $artikel->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                <span class="text-[11px] text-gray-400 mt-1 block">Atau ubah/buat kategori baru di bawah ini:</span>
                <input type="text" name="kategori_baru" value="{{ old('kategori_baru') }}" placeholder="Kategori baru..." class="w-full mt-2 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-700">
            </div>

            {{-- Penerbit --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Penerbit *</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $artikel->penerbit) }}" placeholder="Contoh: Tim Redaksi MindFlow..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-700" required>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Status Publikasi *</label>
                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600" required>
                    <option value="published" {{ old('status', $artikel->status) == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            {{-- Tanggal Terbit --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Tanggal Terbit / Dibuat</label>
                <input type="datetime-local" name="created_at" value="{{ old('created_at', $artikel->created_at->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600">
                <span class="text-[11px] text-gray-400 mt-1 block">Mengubah waktu publikasi artikel secara kustom.</span>
            </div>

            {{-- Gambar Cover --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Gambar Cover</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-2">
                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-purple-50 flex items-center justify-center border border-gray-100 flex-shrink-0">
                        @if($artikel->gambar_cover)
                            <img src="{{ asset('storage/' . $artikel->gambar_cover) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                    <input type="file" name="gambar_cover" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-[#A881C2] file:cursor-pointer hover:file:bg-purple-100 transition">
                </div>
                <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, JPEG, PNG, GIF. Maks: 2MB. Biarkan kosong jika tidak ingin mengubah cover.</span>
            </div>

            {{-- Konten --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Konten Artikel *</label>
                <textarea name="konten" rows="12" placeholder="Tuliskan isi artikel lengkap di sini... (Gunakan baris baru untuk memisahkan paragraf, gunakan **teks** untuk menebalkan kata)" class="w-full px-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 text-gray-700 font-medium leading-relaxed resize-none" required>{{ old('konten', $artikel->konten) }}</textarea>
            </div>
        </div>
    </div>
    <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
        <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 rounded-xl font-bold text-sm transition-all text-center">Batal</a>
        <button type="submit" class="px-6 py-2.5 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-xl font-bold text-sm transition-all shadow-md shadow-purple-200 active:scale-95">Simpan Perubahan</button>
    </div>
</form>
@endsection
