@extends('layouts.admin')

@section('title', 'Laporan & Moderasi')

@push('styles')
<style>
    @keyframes neonWarningPulse {
        0%, 100% {
            box-shadow: 0 0 10px rgba(220, 38, 38, 0.7), inset 0 0 5px rgba(220, 38, 38, 0.2);
            border-color: rgba(220, 38, 38, 0.9);
        }
        50% {
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.9), inset 0 0 10px rgba(220, 38, 38, 0.4);
            border-color: rgba(239, 68, 68, 1);
        }
    }
    .badge-neon-warning {
        background-color: #FEF2F2 !important;
        border: 2.5px solid rgba(220, 38, 38, 0.5) !important;
        animation: neonWarningPulse 2s infinite ease-in-out;
    }
</style>
@endpush

<<<<<<< HEAD
        {{-- Sidebar --}}
        <aside class="w-[280px] bg-white border-r border-gray-200 flex flex-col flex-shrink-0">
            <div class="flex items-center h-[80px] px-8 border-b border-gray-100">
                <img src="{{ asset('images/logo.png') }}" alt="Logo MindFlow" class="w-9 h-9 mr-3 object-contain">
                <h1 class="text-[22px] font-bold text-[#1A1A1A]">Mind<span class="text-[#9B76D6]">Flow</span></h1>
            </div>
            <nav class="flex-1 overflow-y-auto py-6 flex flex-col">
                <div style="padding:0 30px; font-size:18px; font-weight:600; margin-bottom:20px;">Menu</div>
                <ul class="flex flex-col gap-1">
                    <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard</a></li>
                    <li><a href="{{ route('admin.rekrutmen') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Rekrutmen Konselor</a></li>
                    <li><a href="{{ route('admin.laporan') }}" class="sidebar-link active">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Laporan & Moderasi</a></li>
                    <li><a href="{{ route('admin.spesialisasi') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Spesialisasi</a></li>
                    <li><a href="{{ route('forum.index') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Forum MindFlow</a></li>
                    <li><a href="{{ route('admin.artikel.index') }}" class="sidebar-link">
                        <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 12h10"></path></svg>
                        Kelola Artikel</a></li>
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
                <h2 class="text-xl font-bold text-gray-800">Laporan & Moderasi</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->nama_asli ?? 'Admin' }}</span>
                    <img class="h-10 w-10 rounded-full border-2 border-purple-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_asli ?? 'Admin') }}&background=f3e8ff&color=6b21a8" alt="Admin">
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                {{-- Summary --}}
                <div class="grid grid-cols-2 gap-5 mb-8">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold {{ $reports->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $reports->count() }}</div>
                            <div class="text-xs text-gray-500 font-medium">Total Laporan</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold text-orange-600">{{ $reports->where('is_deleted', false)->count() }}</div>
                            <div class="text-xs text-gray-500 font-medium">Perlu Ditindak</div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-base font-bold text-gray-800">Daftar Laporan Pelanggaran</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Tindak lanjuti laporan dari pengguna forum</p>
                    </div>
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Isi Postingan</th>
                                <th class="px-6 py-4 font-semibold">Alasan</th>
                                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 w-1/2">
                                    <div class="text-[11px] text-gray-400 uppercase font-semibold mb-1">Dilaporkan oleh: <span class="text-gray-700">{{ $report->pelapor->nama_samaran ?? ($report->pelapor->nama_asli ?? 'Tidak diketahui') }}</span></div>
                                    <div class="text-[11px] text-red-400 uppercase font-semibold mb-1">Diposting oleh: <span class="text-red-600">{{ $report->pelanggar ? ($report->pelanggar->nama_samaran ?? ($report->pelanggar->nama_asli ?? 'Admin')) : 'Admin MindFlow' }}</span></div>
                                    <div class="text-sm text-gray-700 italic">"{{ Str::limit($report->konten, 100) }}"</div>
                                    @if ($report->type === 'thread')
                                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-600">Forum</span>
                                    @elseif ($report->type === 'reply')
                                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-500">Balasan</span>
                                    @elseif ($report->type === 'artikel')
                                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-50 text-[#A881C2]">Artikel</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold">{{ $report->alasan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center">
                                        @if(!$report->is_deleted)
                                            @if($report->type === 'artikel')
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('artikel.show', $report->target_id) }}" target="_blank" class="flex items-center gap-1.5 px-3 py-2 bg-purple-50 hover:bg-purple-100 text-[#A881C2] rounded-xl text-xs font-bold transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        Lihat
                                                    </a>
                                                    <button type="button" onclick="openDeleteModal('{{ route('admin.artikel.delete', $report->target_id) }}', 'artikel')" class="flex items-center gap-1.5 px-3 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                    <form action="{{ route('admin.laporan.artikel.delete', $report->id) }}" method="POST" class="inline m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex items-center gap-1.5 px-3 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Abaikan
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                @if($report->pelanggar)
                                                    @if(!($report->pelanggar->status === 'muted' && \Carbon\Carbon::parse($report->pelanggar->muted_until)->isFuture()))
                                                        <button onclick="openPunishModal({{ $report->pelanggar->id }}, '{{ addslashes($report->pelanggar->nama_samaran ?? $report->pelanggar->nama_asli ?? 'Pengguna') }}')" class="flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-xl text-xs font-bold hover:bg-amber-600 transition mr-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            Tindak Pelanggar
                                                        </button>
                                                    @endif
                                                @endif
                                                <button type="button" onclick="openDeleteModal('{{ route('admin.forum.delete', ['id' => $report->target_id, 'type' => $report->type]) }}', '{{ $report->type === 'thread' ? 'postingan' : 'balasan' }}')" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        @else
                                            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs font-semibold">{{ $report->type === 'artikel' ? 'Artikel Dihapus' : 'Postingan Dihapus' }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center">
                                        @if($report->pelanggar && $report->pelanggar->status === 'muted' && \Carbon\Carbon::parse($report->pelanggar->muted_until)->isFuture())
                                            <div class="px-4 py-2 rounded-xl text-xs min-w-[120px] text-center badge-neon-warning">
                                                <div class="flex items-center justify-center gap-1.5 mb-1 tracking-widest text-red-700">
                                                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    MUTED
                                                </div>
                                                <span class="admin-countdown font-mono tracking-widest text-red-600 font-bold" data-target="{{ \Carbon\Carbon::parse($report->pelanggar->muted_until)->toIso8601String() }}">00:00:00</span>
                                            </div>
                                        @else
                                            <span class="text-xs font-bold text-gray-400">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-400 text-sm">Tidak ada laporan pelanggaran. 🎉</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Moderation Modal -->
                <div id="punishModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
                    <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Tindak Pelanggar: <span id="punishUserName" class="text-amber-600 ml-1"></span>
                            </h3>
                            <button onclick="closePunishModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <form id="punishForm" method="POST" action="">
                            @csrf
                            <div class="p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Jenis Hukuman</label>
                                    <select name="punishment_type" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-gray-50" required>
                                        <option value="mute">Mute</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Durasi</label>
                                    <select name="duration" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-gray-50" required>
                                        <option value="24">24 Jam</option>
                                        <option value="72">3 Hari</option>
                                        <option value="168">7 Hari</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Alasan Hukuman</label>
                                    <textarea name="reason" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-gray-50 resize-none" placeholder="Tulis alasan..." required></textarea>
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                                <button type="button" onclick="closePunishModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-200 bg-gray-100 rounded-xl transition-colors">Batal</button>
                                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors shadow-sm shadow-amber-500/30">Simpan Hukuman</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirm Modal -->
                <div id="deleteConfirmModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
                    <div class="bg-white rounded-2xl w-full max-w-sm shadow-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Konfirmasi Hapus
                            </h3>
                            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus <span id="deleteTypeName">postingan</span> ini?</h4>
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

                <script>
                    function openPunishModal(userId, userName) {
                        document.getElementById('punishUserName').innerText = userName;
                        document.getElementById('punishForm').action = '/admin/laporan/' + userId + '/punish';
                        document.getElementById('punishModal').classList.remove('hidden');
                    }
                    function closePunishModal() {
                        document.getElementById('punishModal').classList.add('hidden');
                        document.getElementById('punishForm').reset();
                    }

                    // Delete Modal Functions
                    function openDeleteModal(actionUrl, type) {
                        document.getElementById('deleteTypeName').innerText = type;
                        document.getElementById('deleteConfirmForm').action = actionUrl;
                        document.getElementById('deleteConfirmModal').classList.remove('hidden');
                    }
                    function closeDeleteModal() {
                        document.getElementById('deleteConfirmModal').classList.add('hidden');
                        document.getElementById('deleteConfirmForm').action = '';
                    }

                    // Admin Countdowns
                    document.addEventListener('DOMContentLoaded', function() {
                        const countdowns = document.querySelectorAll('.admin-countdown');
                        
                        function updateAdminCountdowns() {
                            const now = new Date().getTime();
                            
                            countdowns.forEach(el => {
                                const targetDate = new Date(el.getAttribute('data-target')).getTime();
                                const distance = targetDate - now;
                                
                                if (distance <= 0) {
                                    el.innerHTML = "SELESAI";
                                    return;
                                }
                                
                                const hours = Math.floor(distance / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                
                                el.innerHTML = 
                                    String(hours).padStart(2, '0') + ":" + 
                                    String(minutes).padStart(2, '0') + ":" + 
                                    String(seconds).padStart(2, '0');
                            });
                        }
                        
                        updateAdminCountdowns();
                        setInterval(updateAdminCountdowns, 1000);
                    });
                </script>
            </main>
=======
@section('content')
{{-- Summary --}}
<div class="grid grid-cols-2 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-2xl font-extrabold {{ $reports->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $reports->count() }}</div>
            <div class="text-xs text-gray-500 font-medium">Total Laporan</div>
>>>>>>> 12c28e0 (merge)
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-2xl font-extrabold text-orange-600">{{ $reports->where('is_deleted', false)->count() }}</div>
            <div class="text-xs text-gray-500 font-medium">Perlu Ditindak</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-base font-bold text-gray-800">Daftar Laporan Pelanggaran</h3>
        <p class="text-xs text-gray-400 mt-0.5">Tindak lanjuti laporan dari pengguna forum</p>
    </div>
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-4 font-semibold">Isi Postingan</th>
                <th class="px-6 py-4 font-semibold">Alasan</th>
                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                <th class="px-6 py-4 text-center font-semibold">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($reports as $report)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-6 py-4 w-1/2">
                    <div class="text-[11px] text-gray-400 uppercase font-semibold mb-1">Dilaporkan oleh: <span class="text-gray-700">{{ $report->pelapor->nama_samaran ?? ($report->pelapor->nama_asli ?? 'Tidak diketahui') }}</span></div>
                    <div class="text-[11px] text-red-400 uppercase font-semibold mb-1">Diposting oleh: <span class="text-red-600">{{ $report->pelanggar ? ($report->pelanggar->nama_samaran ?? ($report->pelanggar->nama_asli ?? 'Admin')) : 'Admin MindFlow' }}</span></div>
                    <div class="text-sm text-gray-700 italic">"{{ Str::limit($report->konten, 100) }}"</div>
                    @if ($report->type === 'thread')
                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-600">Postingan</span>
                    @elseif ($report->type === 'reply')
                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-500">Balasan</span>
                    @elseif ($report->type === 'artikel')
                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-50 text-[#A881C2]">Artikel</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold">{{ $report->alasan }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center items-center">
                        @if(!$report->is_deleted)
                            @if($report->type === 'artikel')
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('artikel.show', $report->target_id) }}" target="_blank" class="flex items-center gap-1.5 px-3 py-2 bg-purple-50 hover:bg-purple-100 text-[#A881C2] rounded-xl text-xs font-bold transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat
                                    </a>
                                    <button type="button" onclick="openDeleteModal('{{ route('admin.artikel.delete', $report->target_id) }}', 'artikel')" class="flex items-center gap-1.5 px-3 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                    <form action="{{ route('admin.laporan.artikel.delete', $report->id) }}" method="POST" class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center gap-1.5 px-3 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Abaikan
                                        </button>
                                    </form>
                                </div>
                            @else
                                @if($report->pelanggar)
                                    @if(!($report->pelanggar->status === 'muted' && \Carbon\Carbon::parse($report->pelanggar->muted_until)->isFuture()))
                                        <button onclick="openPunishModal({{ $report->pelanggar->id }}, '{{ addslashes($report->pelanggar->nama_samaran ?? $report->pelanggar->nama_asli ?? 'Pengguna') }}')" class="flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-xl text-xs font-bold hover:bg-amber-600 transition mr-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Tindak Pelanggar
                                        </button>
                                    @endif
                                @endif
                                <button type="button" onclick="openDeleteModal('{{ route('admin.forum.delete', ['id' => $report->target_id, 'type' => $report->type]) }}', '{{ $report->type === 'thread' ? 'postingan' : 'balasan' }}')" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            @endif
                        @else
                            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs font-semibold">{{ $report->type === 'artikel' ? 'Artikel Dihapus' : 'Postingan Dihapus' }}</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center items-center">
                        @if($report->pelanggar && $report->pelanggar->status === 'muted' && \Carbon\Carbon::parse($report->pelanggar->muted_until)->isFuture())
                            <div class="px-4 py-2 rounded-xl text-xs min-w-[120px] text-center badge-neon-warning">
                                <div class="flex items-center justify-center gap-1.5 mb-1 tracking-widest text-red-700">
                                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    MUTED
                                </div>
                                <span class="admin-countdown font-mono tracking-widest text-red-600 font-bold" data-target="{{ \Carbon\Carbon::parse($report->pelanggar->muted_until)->toIso8601String() }}">00:00:00</span>
                            </div>
                        @else
                            <span class="text-xs font-bold text-gray-400">-</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-gray-400 text-sm">Tidak ada laporan pelanggaran. 🎉</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Moderation Modal -->
<div id="punishModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Tindak Pelanggar: <span id="punishUserName" class="text-amber-600 ml-1"></span>
            </h3>
            <button onclick="closePunishModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="punishForm" method="POST" action="">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Jenis Hukuman</label>
                    <select name="punishment_type" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-gray-50" required>
                        <option value="mute">Mute</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Durasi</label>
                    <select name="duration" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-gray-50" required>
                        <option value="24">24 Jam</option>
                        <option value="72">3 Hari</option>
                        <option value="168">7 Hari</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Alasan Hukuman</label>
                    <textarea name="reason" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-gray-50 resize-none" placeholder="Tulis alasan..." required></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="closePunishModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-200 bg-gray-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors shadow-sm shadow-amber-500/30">Simpan Hukuman</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div id="deleteConfirmModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Konfirmasi Hapus
            </h3>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus <span id="deleteTypeName">postingan</span> ini?</h4>
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

<script>
    function openPunishModal(userId, userName) {
        document.getElementById('punishUserName').innerText = userName;
        document.getElementById('punishForm').action = '/admin/laporan/' + userId + '/punish';
        document.getElementById('punishModal').classList.remove('hidden');
    }
    function closePunishModal() {
        document.getElementById('punishModal').classList.add('hidden');
        document.getElementById('punishForm').reset();
    }

    // Delete Modal Functions
    function openDeleteModal(actionUrl, type) {
        document.getElementById('deleteTypeName').innerText = type;
        document.getElementById('deleteConfirmForm').action = actionUrl;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
        document.getElementById('deleteConfirmForm').action = '';
    }

    // Admin Countdowns
    document.addEventListener('DOMContentLoaded', function() {
        const countdowns = document.querySelectorAll('.admin-countdown');
        
        function updateAdminCountdowns() {
            const now = new Date().getTime();
            
            countdowns.forEach(el => {
                const targetDate = new Date(el.getAttribute('data-target')).getTime();
                const distance = targetDate - now;
                
                if (distance <= 0) {
                    el.innerHTML = "SELESAI";
                    return;
                }
                
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                el.innerHTML = 
                    String(hours).padStart(2, '0') + ":" + 
                    String(minutes).padStart(2, '0') + ":" + 
                    String(seconds).padStart(2, '0');
            });
        }
        
        updateAdminCountdowns();
        setInterval(updateAdminCountdowns, 1000);
    });
</script>
@endsection