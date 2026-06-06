@extends('layouts.admin')

@section('title', 'Kelola FAQ')

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
        <h3 class="text-lg font-bold text-gray-800">Daftar Tanya Jawab (FAQ)</h3>
        <p class="text-xs text-gray-400 mt-0.5">Kelola FAQ yang ditampilkan di halaman publik dan pengaturan pengguna.</p>
    </div>
    <button onclick="openModal('modal-tambah')" class="flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah FAQ
    </button>
</div>

{{-- Tabel FAQ --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 font-semibold w-16">#</th>
                <th class="px-6 py-4 font-semibold w-1/3">Pertanyaan</th>
                <th class="px-6 py-4 font-semibold">Jawaban</th>
                <th class="px-6 py-4 text-center font-semibold w-32">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($faqs as $i => $faq)
            <tr class="hover:bg-gray-50/50 transition align-top">
                <td class="px-6 py-4 font-bold text-gray-400">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-bold text-gray-800 whitespace-pre-line">{{ $faq->question }}</td>
                <td class="px-6 py-4 text-gray-600 whitespace-pre-line">{!! strip_tags($faq->answer, '<a><strong><em><b><i><br>') !!}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        {{-- Tombol Edit --}}
                        <button 
                            data-id="{{ $faq->id }}" 
                            data-question="{{ $faq->question }}" 
                            data-answer="{{ $faq->answer }}" 
                            onclick="openEditModal(this)" 
                            class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" 
                            title="Edit"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        {{-- Tombol Hapus --}}
                        <button 
                            data-id="{{ $faq->id }}" 
                            data-question="{{ $faq->question }}" 
                            onclick="openDeleteModal(this)" 
                            class="p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition" 
                            title="Hapus"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-semibold">Belum ada FAQ.</p>
                    <p class="text-xs mt-1">Klik tombol "Tambah FAQ" untuk memulai.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div id="modal-tambah" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-800">Tambah FAQ</h3>
            <button onclick="closeModal('modal-tambah')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pertanyaan</label>
                <textarea name="question" required rows="3" placeholder="cth: Bagaimana cara menghubungi layanan bantuan?" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jawaban (Mendukung tag HTML dasar seperti &lt;strong&gt;, &lt;a&gt;)</label>
                <textarea name="answer" required rows="5" placeholder="cth: Anda dapat mengirim email ke support@mindflow.com atau..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('modal-tambah')" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded-xl transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
<div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-gray-800">Edit FAQ</h3>
            <button onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form id="form-edit" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pertanyaan</label>
                <textarea id="edit-question" name="question" required rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jawaban (Mendukung tag HTML dasar seperti &lt;strong&gt;, &lt;a&gt;)</label>
                <textarea id="edit-answer" name="answer" required rows="5" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 outline-none transition resize-none"></textarea>
            </div>
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
            <h3 class="text-lg font-bold text-gray-800">Hapus FAQ</h3>
            <p class="text-sm text-gray-500 mt-2">Apakah Anda yakin ingin menghapus FAQ <strong id="delete-question"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
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
    function openEditModal(btn) {
        const id = btn.getAttribute('data-id');
        const question = btn.getAttribute('data-question');
        const answer = btn.getAttribute('data-answer');
        
        document.getElementById('edit-question').value = question;
        document.getElementById('edit-answer').value = answer;
        document.getElementById('form-edit').action = '/admin/faq/' + id;
        openModal('modal-edit');
    }
    function openDeleteModal(btn) {
        const id = btn.getAttribute('data-id');
        const question = btn.getAttribute('data-question');
        
        document.getElementById('delete-question').textContent = '"' + question + '"';
        document.getElementById('form-hapus').action = '/admin/faq/' + id;
        openModal('modal-hapus');
    }
    // Tutup modal jika klik backdrop
    document.querySelectorAll('.modal-backdrop').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
    });
</script>
@endpush
