@extends('layouts.admin')

@section('title', 'Kelola Artikel')

@section('content')
{{-- Action Panel & Filters --}}
<div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1">
            <form action="{{ route('admin.artikel.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select name="kategori" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-[#A881C2] bg-gray-50/50 font-medium text-gray-600">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-xl font-bold text-sm transition-all shadow-md shadow-purple-200">Filter</button>
                @if(request()->anyFilled(['search', 'kategori', 'status']))
                    <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl font-bold text-sm text-center transition-all">Reset</a>
                @endif
            </form>
        </div>
        <a href="{{ route('admin.artikel.create') }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-purple-200 flex-shrink-0 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tambah Artikel
        </a>
    </div>
</div>

{{-- Table --}}
<div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-base font-bold text-gray-800">Daftar Artikel</h3>
            <p class="text-xs text-gray-400 mt-0.5">Kelola seluruh artikel edukasi dan motivasi platform</p>
        </div>
        <span class="text-xs font-semibold text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg">Total: {{ $artikels->total() }} Artikel</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold w-[80px]">Cover</th>
                    <th class="px-6 py-4 font-semibold">Judul</th>
                    <th class="px-6 py-4 font-semibold">Kategori</th>
                    <th class="px-6 py-4 font-semibold">Penerbit</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Tanggal Terbit</th>
                    <th class="px-6 py-4 text-center font-semibold w-[120px]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($artikels as $artikel)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-purple-50 flex items-center justify-center border border-gray-100">
                            @if($artikel->gambar_cover)
                                <img src="{{ asset('storage/' . $artikel->gambar_cover) }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <svg class="w-5 h-5 text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-[280px]">
                        <a href="{{ route('artikel.show', $artikel->artikel_id) }}" target="_blank" class="font-bold text-gray-800 hover:text-[#9B76D6] transition truncate mb-0.5 block" title="{{ $artikel->judul }}">{{ $artikel->judul }}</a>
                        <div class="text-[11px] text-gray-400">ID: #{{ $artikel->artikel_id }} · Oleh: {{ $artikel->admin->nama_asli ?? 'Admin' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($artikel->kategori)
                            <span class="inline-flex items-center px-2.5 py-1 bg-purple-50 text-[#A881C2] text-xs font-bold rounded-lg">{{ $artikel->kategori }}</span>
                        @else
                            <span class="text-xs text-gray-400 font-semibold">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-gray-700">{{ $artikel->penerbit ?: 'Admin MindFlow' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($artikel->status === 'published')
                            <span class="inline-flex items-center px-2.5 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-lg">Published</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-lg">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-gray-500">{{ $artikel->created_at->translatedFormat('d F Y H:i') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('artikel.show', $artikel->artikel_id) }}" target="_blank" class="flex items-center justify-center w-8 h-8 bg-purple-50 text-[#A881C2] rounded-xl hover:bg-purple-100 transition shadow-sm" title="Lihat Detail Artikel">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.artikel.edit', $artikel->artikel_id) }}" class="flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition shadow-sm" title="Edit Artikel">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button type="button" onclick="openDeleteModal('{{ route('admin.artikel.destroy', $artikel->artikel_id) }}', '{{ addslashes($artikel->judul) }}')" class="flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition shadow-sm" title="Hapus Artikel">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                        <p class="text-gray-400 text-sm">Tidak ada artikel ditemukan. Mulai tulis artikel baru! 📝</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($artikels->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $artikels->links() }}
    </div>
    @endif
</div>

<!-- Delete Confirm Modal -->
<div id="deleteConfirmModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Konfirmasi Hapus
            </h3>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus Artikel Ini?</h4>
            <p class="text-xs text-gray-500 max-h-[60px] overflow-hidden truncate" id="deleteTargetTitle"></p>
            <p class="text-xs text-red-500 mt-2 font-semibold">Tindakan ini tidak bisa dibatalkan dan semua data bookmark & laporan artikel ini akan terhapus.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-center gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-200 bg-gray-100 rounded-xl transition-colors">Batal</button>
            <form id="deleteConfirmForm" method="POST" action="" class="m-0">
                @csrf @method('DELETE')
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors shadow-sm shadow-red-600/30">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openDeleteModal(actionUrl, title) {
        document.getElementById('deleteTargetTitle').innerText = '"' + title + '"';
        document.getElementById('deleteConfirmForm').action = actionUrl;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
        document.getElementById('deleteConfirmForm').action = '';
    }
</script>
@endpush
