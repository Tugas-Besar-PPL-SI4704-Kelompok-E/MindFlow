@extends('layouts.dashboard')

@section('title', 'Dompet & Pencairan - MindFlow')
@section('header', 'Dompet & Pencairan Dana')

@section('content')
{{-- Flash Alerts --}}
@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <span class="font-bold text-sm">✅ {{ session('success') }}</span>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="bg-red-50 border border-red-100 text-red-800 px-6 py-4 rounded-2xl mb-8">
        <ul class="list-disc list-inside text-sm font-semibold">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
    {{-- Saldo Card --}}
    <div class="lg:col-span-5">
        <div class="bg-gradient-to-tr from-purple-800 to-indigo-900 rounded-[32px] p-8 text-white shadow-xl relative overflow-hidden h-full flex flex-col justify-between min-h-[260px]">
            <div class="absolute -right-16 -top-16 w-44 h-44 rounded-full bg-white/5 border border-white/10"></div>
            <div class="absolute -left-10 -bottom-10 w-32 h-32 rounded-full bg-white/5 border border-white/10"></div>
            
            <div class="relative z-10">
                <span class="text-xs uppercase tracking-widest text-purple-200 font-bold">Saldo Dompet Saya</span>
                <h3 class="text-4xl font-black mt-3 mb-1 font-mono">Rp{{ number_format($profil->saldo, 0, ',', '.') }}</h3>
                <p class="text-xs text-purple-300 font-medium font-bold">Uang siap dicairkan dari sesi yang telah selesai.</p>
            </div>

            <div class="relative z-10 border-t border-white/10 pt-4 mt-4">
                <span class="text-xs uppercase tracking-widest text-indigo-200 font-bold">Saldo Tertahan (Escrow)</span>
                @php
                    $saldoTertahan = \App\Models\SesiKonseling::where('profil_konselor_id', $profil->profil_konselor_id)
                        ->where('payment_status', 'paid')
                        ->whereNotIn('status', ['completed', 'cancelled', 'rejected'])
                        ->count() * ($profil->harga_per_sesi ?? 0);
                @endphp
                <h4 class="text-2xl font-bold mt-1.5 font-mono text-indigo-100">Rp{{ number_format($saldoTertahan, 0, ',', '.') }}</h4>
                <p class="text-[11px] text-indigo-200/80 mt-1 font-medium">Uang dari booking yang sudah disetujui admin. Akan masuk ke saldo utama Anda otomatis setelah sesi selesai & Anda menyimpan catatan evaluasi.</p>
            </div>

            <div class="relative z-10 flex gap-3 mt-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 rounded-xl text-xs font-semibold backdrop-blur-sm">
                    🔒 Escrow platform aktif
                </span>
            </div>
        </div>
    </div>

    {{-- Form Pencairan --}}
    <div class="lg:col-span-7">
        <div class="bg-white rounded-[28px] border border-gray-100 p-8 shadow-sm h-full">
            <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2 0 .62.31 1.16.78 1.48L12 16l1.22-4.52A1.99 1.99 0 0014 10c0-1.1-.9-2-2-2zm0 10v2m0-16V2m4 4l1.5-1.5m-11 0L8 4m8 12l1.5 1.5M5.5 17.5L7 19.5"></path></svg>
                Tarik Dana / Cairkan Honorarium
            </h4>

            <form action="{{ route('konselor.dompet.withdraw') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama Bank</label>
                        <select name="bank_name" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-600 text-gray-700 font-bold" required>
                            <option value="BCA">BCA (Bank Central Asia)</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BNI">BNI (Bank Negara Indonesia)</option>
                            <option value="BRI">BRI (Bank Rakyat Indonesia)</option>
                            <option value="Gopay">GoPay E-Wallet</option>
                            <option value="Dana">DANA E-Wallet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nomor Rekening</label>
                        <input type="text" name="account_number" placeholder="cth: 880293847382" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-600 text-gray-700 font-bold" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama Pemilik Rekening</label>
                    <input type="text" name="account_holder" placeholder="cth: Dr. Riana Ar-Zahra" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-600 text-gray-700 font-bold" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jumlah Penarikan (Rp)</label>
                    <input type="number" name="amount" min="10000" max="{{ (int) $profil->saldo }}" placeholder="Min. Rp10.000" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-600 text-gray-700 font-bold" required>
                    <p class="text-xs text-gray-400 mt-1">Saldo saat ini: Rp{{ number_format($profil->saldo, 0, ',', '.') }}</p>
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md shadow-purple-500/20 active:scale-[0.99]" {{ $profil->saldo < 10000 ? 'disabled' : '' }}>
                    Ajukan Penarikan Dana
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Riwayat Transaksi --}}
<div class="bg-white rounded-[28px] border border-gray-100 overflow-hidden shadow-sm">
    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Riwayat Keuangan & Transaksi</h3>
            <p class="text-xs text-gray-400 mt-0.5">Semua rekaman penambahan honorarium sesi selesai dan penarikan saldo Anda.</p>
        </div>
    </div>

    <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-8 py-4 font-semibold">Tanggal</th>
                <th class="px-8 py-4 font-semibold">Tipe</th>
                <th class="px-8 py-4 font-semibold">Deskripsi</th>
                <th class="px-8 py-4 font-semibold">Jumlah</th>
                <th class="px-8 py-4 text-center font-semibold">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 font-medium">
            @forelse($transactions as $tx)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-8 py-4 text-xs text-gray-400 font-mono">
                    {{ $tx->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-8 py-4">
                    @if($tx->type === 'deposit')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Honorarium Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Penarikan Dana
                        </span>
                    @endif
                </td>
                <td class="px-8 py-4 text-gray-600 text-sm">
                    {{ $tx->description }}
                </td>
                <td class="px-8 py-4 font-bold {{ $tx->type === 'deposit' ? 'text-emerald-600' : 'text-blue-600' }}">
                    {{ $tx->type === 'deposit' ? '+' : '-' }}Rp{{ number_format($tx->amount, 0, ',', '.') }}
                </td>
                <td class="px-8 py-4 text-center">
                    @if($tx->status === 'approved')
                        <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">✅ Selesai</span>
                    @elseif($tx->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold">⏳ Diproses</span>
                    @elseif($tx->status === 'rejected')
                        <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold">❌ Ditolak</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-8 py-16 text-center text-gray-400">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.1 0-2 .9-2 2 0 .62.31 1.16.78 1.48L12 16l1.22-4.52A1.99 1.99 0 0014 10c0-1.1-.9-2-2-2zm0 10v2m0-16V2m4 4l1.5-1.5m-11 0L8 4m8 12l1.5 1.5M5.5 17.5L7 19.5"></path></svg>
                    <p class="text-sm font-semibold">Belum ada riwayat transaksi dompet.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
