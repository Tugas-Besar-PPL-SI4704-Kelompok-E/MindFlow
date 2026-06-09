@extends('layouts.admin')

@section('title', 'Kelola Transaksi & Keuangan')

@section('content')
{{-- Flash Alerts --}}
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm font-semibold">
        <span>✅ {{ session('success') }}</span>
    </div>
@endif

{{-- Dashboard Ringkasan Keuangan --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-2xl font-black text-gray-900">
                Rp{{ number_format($sessions->where('payment_status', 'paid')->sum(fn($s) => $s->profilKonselor->harga_per_sesi ?? 0), 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-0.5">Total Uang Ditampung (Escrow)</div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-2xl font-black text-yellow-600">
                {{ $sessions->where('payment_status', 'waiting_verification')->count() }} Transaksi
            </div>
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-0.5">Perlu Verifikasi Bayar</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <div class="text-2xl font-black text-blue-600">
                {{ $withdrawals->where('status', 'pending')->count() }} Pengajuan
            </div>
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-0.5">Menunggu Pencairan</div>
        </div>
    </div>
</div>

{{-- Tab Interface --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    <div class="border-b border-gray-100 bg-gray-50/50 flex">
        <button id="tabBtnPayments" class="px-8 py-5 text-sm font-bold border-b-2 border-purple-600 text-purple-700 outline-none transition-all" onclick="switchTab('payments')">
            Log & Verifikasi Pembayaran Sesi
        </button>
        <button id="tabBtnWithdrawals" class="px-8 py-5 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 outline-none transition-all" onclick="switchTab('withdrawals')">
            Pengajuan Pencairan Saldo Konselor
            @if($withdrawals->where('status', 'pending')->count() > 0)
                <span class="ml-2 px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-extrabold">{{ $withdrawals->where('status', 'pending')->count() }}</span>
            @endif
        </button>
    </div>

    {{-- Content Tab 1: Payments --}}
    <div id="tabContentPayments" class="block">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">Detail Sesi</th>
                    <th class="px-6 py-4 font-semibold">User (Mahasiswa)</th>
                    <th class="px-6 py-4 font-semibold">Konselor</th>
                    <th class="px-6 py-4 font-semibold">Jumlah & Metode</th>
                    <th class="px-6 py-4 text-center font-semibold">Status Pembayaran</th>
                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 font-medium">
                @forelse($sessions as $s)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-400 font-mono mb-0.5">Sesi #{{ $s->sesi_konseling_id }}</div>
                        <div class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($s->jadwal)->translatedFormat('d M Y, H:i') }}</div>
                        <div class="text-[11px] font-black uppercase text-gray-400 mt-1">Status Sesi: {{ $s->status }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $s->user->nama_asli ?? 'User' }}</div>
                        <div class="text-xs text-gray-500">{{ $s->user->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $s->profilKonselor->nama }}</div>
                        <div class="text-xs text-purple-600">{{ $s->profilKonselor->spesialisasi }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-extrabold text-gray-900">Rp{{ number_format($s->profilKonselor->harga_per_sesi ?? 0, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 uppercase font-bold">{{ str_replace('-', ' ', $s->payment_method) }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($s->payment_status === 'paid')
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">Lunas (Paid)</span>
                        @elseif($s->payment_status === 'waiting_verification')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold">⏳ Menunggu Verifikasi</span>
                        @elseif($s->payment_status === 'pending')
                            <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-bold">Belum Bayar</span>
                        @elseif($s->payment_status === 'refunded')
                            <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold">Dikembalikan</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-bold">{{ $s->payment_status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($s->payment_status === 'waiting_verification')
                            <form action="{{ route('admin.transaksi.verify-payment', $s->sesi_konseling_id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Verifikasi pembayaran untuk sesi ini?')">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold transition">
                                    Verifikasi
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                        <p class="text-sm font-semibold">Belum ada riwayat transaksi sesi konseling.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Content Tab 2: Withdrawals --}}
    <div id="tabContentWithdrawals" class="hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">Tanggal Pengajuan</th>
                    <th class="px-6 py-4 font-semibold">Konselor</th>
                    <th class="px-6 py-4 font-semibold">Bank & Akun Tujuan</th>
                    <th class="px-6 py-4 font-semibold">Jumlah Penarikan</th>
                    <th class="px-6 py-4 text-center font-semibold">Status</th>
                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 font-medium">
                @forelse($withdrawals as $tx)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-xs font-mono text-gray-400">
                        {{ $tx->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $tx->profilKonselor->nama }}</div>
                        <div class="text-xs text-purple-600 font-semibold">{{ $tx->profilKonselor->spesialisasi }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $tx->bank_name }}</div>
                        <div class="text-sm text-gray-700 font-mono">{{ $tx->account_number }}</div>
                        <div class="text-xs text-gray-400">a.n. {{ $tx->account_holder }}</div>
                    </td>
                    <td class="px-6 py-4 font-extrabold text-blue-600">
                        Rp{{ number_format($tx->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($tx->status === 'approved')
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">Disetujui</span>
                        @elseif($tx->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold">⏳ Menunggu</span>
                        @elseif($tx->status === 'rejected')
                            <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($tx->status === 'pending')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.transaksi.approve-withdrawal', $tx->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Setujui pencairan dana ini?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold transition">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.transaksi.reject-withdrawal', $tx->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Tolak pencairan dana ini?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                        <p class="text-sm font-semibold">Belum ada pengajuan pencairan saldo konselor.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function switchTab(tab) {
        const payTabBtn = document.getElementById('tabBtnPayments');
        const drawTabBtn = document.getElementById('tabBtnWithdrawals');
        const payTabCont = document.getElementById('tabContentPayments');
        const drawTabCont = document.getElementById('tabContentWithdrawals');

        if (tab === 'payments') {
            payTabBtn.classList.remove('border-transparent', 'text-gray-500');
            payTabBtn.classList.add('border-purple-600', 'text-purple-700');
            drawTabBtn.classList.remove('border-purple-600', 'text-purple-700');
            drawTabBtn.classList.add('border-transparent', 'text-gray-500');

            payTabCont.classList.remove('hidden');
            payTabCont.classList.add('block');
            drawTabCont.classList.remove('block');
            drawTabCont.classList.add('hidden');
        } else {
            drawTabBtn.classList.remove('border-transparent', 'text-gray-500');
            drawTabBtn.classList.add('border-purple-600', 'text-purple-700');
            payTabBtn.classList.remove('border-purple-600', 'text-purple-700');
            payTabBtn.classList.add('border-transparent', 'text-gray-500');

            drawTabCont.classList.remove('hidden');
            drawTabCont.classList.add('block');
            payTabCont.classList.remove('block');
            payTabCont.classList.add('hidden');
        }
    }
</script>
@endsection
