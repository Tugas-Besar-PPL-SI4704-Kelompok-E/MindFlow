@extends('layouts.admin')

@section('title', 'Tambah Artikel')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.artikel.index') }}" class="text-gray-400 hover:text-[#A881C2] transition-colors p-1.5 rounded-lg hover:bg-gray-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
    </a>
    <h2 class="text-xl font-bold text-gray-800">Tambah Artikel Baru</h2>
</div>

<form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl bg-white/80 backdrop-blur-xl border border-white/50 rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] overflow-hidden">
    @csrf
    <div class="p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Judul --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Judul Artikel *</label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Tuliskan judul artikel yang menarik..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-700" required>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Kategori / Tema</label>
                <select name="kategori" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($availableKategoris as $kat)
                        <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                <span class="text-[11px] text-gray-400 mt-1 block">Atau buat kategori baru di bawah ini:</span>
                <input type="text" name="kategori_baru" value="{{ old('kategori_baru') }}" placeholder="Kategori baru..." class="w-full mt-2 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-700">
            </div>

            {{-- Penerbit --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Penerbit *</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $defaultPenerbit) }}" placeholder="Contoh: Tim Redaksi MindFlow..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-700" required>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Status Publikasi *</label>
                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600" required>
                    <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            {{-- Tanggal Terbit --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Tanggal Terbit / Dibuat (Opsional)</label>
                <input type="datetime-local" name="created_at" value="{{ old('created_at') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600">
                <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong untuk menggunakan waktu sekarang.</span>
            </div>

            {{-- Gambar Cover --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Gambar Cover</label>
                <div class="flex items-center gap-4">
                    <input type="file" name="gambar_cover" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-[#A881C2] file:cursor-pointer hover:file:bg-purple-100 transition">
                </div>
                <span class="text-[11px] text-gray-400 mt-1.5 block">Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</span>
            </div>

            {{-- Konten --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Konten Artikel *</label>
                <textarea name="konten" rows="12" placeholder="Tuliskan isi artikel lengkap di sini... (Gunakan baris baru untuk memisahkan paragraf, gunakan **teks** untuk menebalkan kata)" class="w-full px-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 text-gray-700 font-medium leading-relaxed resize-none" required>{{ old('konten') }}</textarea>
            </div>
        </div>
    </div>
    <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50 flex items-center justify-end gap-3">
        <a href="{{ route('admin.artikel.index') }}" class="px-6 py-3 bg-white/50 border border-gray-200 hover:bg-white text-gray-600 rounded-2xl font-bold text-sm transition-all text-center shadow-sm">Batal</a>
        <button type="submit" class="px-6 py-3 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-purple-200 active:scale-95">Simpan Artikel</button>
    </div>
</form>
@endsection
