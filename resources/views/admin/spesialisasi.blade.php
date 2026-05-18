<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Spesialisasi - MindFlow Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar-link { display:flex; align-items:center; padding:14px 30px; font-weight:600; font-size:15px; color:#1A1A1A; text-decoration:none; border-left:4px solid transparent; transition:all .2s; }
        .sidebar-link:hover { background:#F9F9F9; }
        .sidebar-link.active { background:#F4EEFB; color:#9B76D6; border-left-color:#9B76D6; }
        .sidebar-link svg { width:22px; height:22px; margin-right:14px; stroke:currentColor; stroke-width:2; fill:none; }
        /* Modal backdrop */
        .modal-backdrop { background:rgba(0,0,0,.4); backdrop-filter:blur(4px); }
        .modal-content { animation: modalIn .25s ease-out; }
        @keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-900">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-[280px] bg-white border-r border-gray-200 flex flex-col flex-shrink-0">
            <div class="flex items-center h-[80px] px-8 border-b border-gray-100">
                <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" class="w-9 h-9 mr-3 object-contain">
                <h1 class="text-[22px] font-bold text-[#1A1A1A]">Mind<span class="text-[#9B76D6]">Flow</span></h1>
            </div>
            <nav class="flex-1 overflow-y-auto py-6 flex flex-col">
                <ul class="flex flex-col gap-1">
                    <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Laporan & Moderasi</a></li>
                    <li><a href="{{ route('admin.spesialisasi') }}" class="sidebar-link active">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Spesialisasi</a></li>
                    <li><a href="{{ route('forum.index') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Forum MindFlow</a></li>
                </ul>
                <div class="mt-auto border-t border-gray-100 pt-4">
                    <a href="{{ route('admin.settings') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Settings</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left" style="color:#ef4444; background:none; border:none; cursor:pointer;">
                            <svg viewBox="0 0 24 24" stroke="#ef4444"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar</button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-[72px] bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-800">Kelola Spesialisasi</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Admin' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Admin') }}&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">

                {{-- Flash Message --}}
                @if(session('success'))
                <div id="flash-msg" class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-semibold">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                    <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-green-400 hover:text-green-600">&times;</button>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                {{-- Header + Tombol Tambah --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Kategori Spesialisasi</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Kelola kategori spesialisasi yang tersedia untuk konselor.</p>
                    </div>
                    <button onclick="openModal('modal-tambah')" class="flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Spesialisasi
                    </button>
                </div>

                {{-- Tabel --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
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
            </main>
        </div>
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
</body>
</html>
