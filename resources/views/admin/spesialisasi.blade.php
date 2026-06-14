@extends('layouts.admin')

@section('title', 'Kelola Spesialisasi')

@push('styles')
<style>
    /* Modal backdrop override */
    .modal-backdrop { background:rgba(0,0,0,.4); backdrop-filter:blur(4px); }
    .modal-content { animation: modalIn .25s ease-out; }
    @keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
</style>
@endpush

@section('content')
{{-- Header + Tombol Tambah --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-lg font-bold text-gray-800">Daftar Kategori Spesialisasi</h3>
        <p class="text-xs text-gray-400 mt-0.5">Kelola kategori spesialisasi yang tersedia untuk konselor.</p>
    </div>
    <button onclick="openModal('modal-tambah')" class="flex items-center gap-2 bg-[#A881C2] hover:bg-[#8A64A4] text-white text-sm font-bold px-6 py-3 rounded-2xl transition-all shadow-lg shadow-purple-200 active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Spesialisasi
    </button>
</div>

{{-- Tabel --}}
<div class="bg-white/80 backdrop-blur-xl rounded-[32px] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 font-semibold">#</th>
                <th class="px-6 py-4 font-semibold">Nama Spesialisasi</th>
                <th class="px-6 py-4 font-semibold">Jumlah Konselor</th>
                <th class="px-6 py-4 text-center font-semibold">Status</th>
                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($spesialisasis as $i => $s)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-6 py-4 font-bold text-gray-400">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-bold text-gray-800">{{ $s->nama }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $s->jumlah_konselor }} Konselor</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $s->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $s->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        {{-- Tombol Edit --}}
                        <button onclick="openEditModal({{ $s->id }}, '{{ addslashes($s->nama) }}')" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        {{-- Tombol Toggle Status --}}
                        <form action="{{ route('admin.spesialisasi.toggle', $s->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-lg {{ $s->is_active ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} transition" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                @if($s->is_active)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </button>
                        </form>
                        {{-- Tombol Hapus --}}
                        <button onclick="openDeleteModal({{ $s->id }}, '{{ addslashes($s->nama) }}')" class="p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <p class="text-sm font-semibold">Belum ada spesialisasi.</p>
                    <p class="text-xs mt-1">Klik tombol "Tambah Spesialisasi" untuk memulai.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div id="modal-tambah" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-800">Tambah Spesialisasi</h3>
            <button onclick="closeModal('modal-tambah')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form action="{{ route('admin.spesialisasi.store') }}" method="POST">
            @csrf
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Spesialisasi</label>
            <input type="text" name="nama" required placeholder="cth: Kesehatan Mental" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition">
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-tambah')" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded-xl transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
<div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-800">Edit Spesialisasi</h3>
            <button onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Spesialisasi</label>
            <input type="text" id="edit-nama" name="nama" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition">
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-edit')" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">Perbarui</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL HAPUS ================= --}}
<div id="modal-hapus" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex flex-col items-center text-center mb-5">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Hapus Spesialisasi</h3>
            <p class="text-sm text-gray-500 mt-2">Apakah Anda yakin ingin menghapus spesialisasi <strong id="delete-nama"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <form id="form-hapus" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeModal('modal-hapus')" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        el.classList.add('flex');
    }
    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
    }
    function openEditModal(id, nama) {
        document.getElementById('edit-nama').value = nama;
        document.getElementById('form-edit').action = '/admin/spesialisasi/' + id;
        openModal('modal-edit');
    }
    function openDeleteModal(id, nama) {
        document.getElementById('delete-nama').textContent = '"' + nama + '"';
        document.getElementById('form-hapus').action = '/admin/spesialisasi/' + id;
        openModal('modal-hapus');
    }
    // Tutup modal jika klik backdrop
    document.querySelectorAll('.modal-backdrop').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
    });
</script>
@endpush
