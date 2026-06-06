@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Checkout Pembayaran</h2>
        <span class="px-4 py-1.5 rounded-full bg-purple-50 text-[#A881C2] text-xs font-bold border border-purple-100 uppercase tracking-wider">
            Sesi #{{ $sesi->sesi_konseling_id }}
        </span>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-[32px] p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 mb-8">
        {{-- Ringkasan Sesi --}}
        <div class="flex items-center gap-6 pb-6 border-b border-gray-100 mb-6">
            <div class="w-20 h-20 rounded-[20px] bg-purple-50 p-1 flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($sesi->profilKonselor->nama) }}&background=A881C2&color=fff&size=100&bold=true" class="w-full h-full object-cover rounded-[18px]">
            </div>
            <div>
                <h3 class="font-extrabold text-gray-950 text-lg">{{ $sesi->profilKonselor->nama }}</h3>
                <p class="text-sm text-gray-500 font-semibold">{{ $sesi->profilKonselor->spesialisasi }}</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-purple-50 text-[#A881C2] text-[10px] font-black uppercase tracking-wider border border-purple-100">
                        {{ \Carbon\Carbon::parse($sesi->jadwal)->translatedFormat('d M Y, H:i') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-gray-50 text-gray-600 text-[10px] font-black uppercase tracking-wider border border-gray-100">
                        {{ ucfirst($sesi->media_konseling) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Detail Tarif --}}
        <div class="space-y-4 mb-8">
            <div class="flex justify-between items-center text-sm font-medium text-gray-500">
                <span>Biaya Konseling (1 Sesi)</span>
                <span class="text-gray-900 font-bold">Rp{{ number_format($sesi->profilKonselor->harga_per_sesi, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-sm font-medium text-gray-500">
                <span>Biaya Layanan & Escrow</span>
                <span class="text-gray-900 font-bold">Rp0</span>
            </div>
            <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                <span class="text-base font-extrabold text-gray-900">Total Tagihan</span>
                <span class="text-2xl font-black text-[#A881C2]">Rp{{ number_format($sesi->profilKonselor->harga_per_sesi, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Instruksi Pembayaran --}}
        <div class="p-6 bg-gray-50/50 rounded-2xl border border-gray-100 mb-8">
            @if($sesi->payment_method === 'transfer')
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-purple-900 font-bold mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <span>Transfer Bank Mandiri</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-gray-200/60 shadow-sm">
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Nomor Virtual Account</p>
                        <div class="flex items-center justify-between">
                            <span class="font-mono font-extrabold text-gray-900 text-lg select-all">8801289384758293</span>
                            <span class="text-xs font-bold text-purple-600 hover:text-purple-800 cursor-pointer">Salin</span>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 leading-relaxed font-semibold">
                        <p class="mb-1">1. Lakukan transfer sejumlah total tagihan di atas ke nomor Virtual Account Mandiri.</p>
                        <p class="mb-1">2. Simpan bukti transfer Anda.</p>
                        <p>3. Klik tombol **Konfirmasi Transfer** di bawah. Admin akan segera memverifikasi pembayaran Anda.</p>
                    </div>
                </div>
            @else
                <div class="space-y-4 flex flex-col items-center">
                    <div class="flex items-center gap-3 text-purple-900 font-bold mb-2 self-start">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Pembayaran E-Wallet QRIS</span>
                    </div>
                    
                    {{-- Simulasi QR Code --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-2">
                        <div class="w-48 h-48 bg-gray-50 border border-gray-200/80 rounded-xl flex items-center justify-center p-2 relative overflow-hidden">
                            {{-- QR Placeholder styling using premium vector-like css patterns --}}
                            <div class="absolute inset-0 bg-gradient-to-tr from-purple-50/20 to-indigo-50/20"></div>
                            <svg class="w-40 h-40 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h6v6H3V3zm1 1v4h4V4H4zm1 1h2v2H5V5zm6-2h10v10H11V3zm1 1v8h8V4h-8zm1 1h6v6h-6V5zM3 11h6v10H3V11zm1 1v8h4v-8H4zm1 1h2v2H5v-2zm9-2h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 2h2v2h-2v-2zm4-4h2v2h-2v-2zm0 4h2v2h-2v-2zm2-2h2v2h-2v-2zm-6 4h2v2h-2v-2zm2 2h2v2h-2v-2zm4-4h2v2h-2v-2zm0 4h2v2h-2v-2zm-6 2h2v2h-2v-2zm2-2h2v2h-2v-2zm4 2h2v2h-2v-2z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">MindFlow QRIS Merchant</span>
                    </div>

                    <div class="text-xs text-gray-500 leading-relaxed font-semibold text-center max-w-sm">
                        <p class="mb-1">Pindai QRIS di atas menggunakan aplikasi e-wallet Anda (Gopay/OVO/Dana/LinkAja).</p>
                        <p>Setelah selesai membayar, klik tombol **Selesaikan Pembayaran** di bawah untuk konfirmasi otomatis.</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Form Aksi Bayar --}}
        <form action="{{ route('booking.pay', $sesi->sesi_konseling_id) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white py-4 rounded-2xl font-bold shadow-lg shadow-purple-500/20 transition-all duration-300 flex items-center justify-center gap-2">
                <span>{{ $sesi->payment_method === 'transfer' ? 'Konfirmasi Transfer' : 'Selesaikan Pembayaran' }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </form>
    </div>

    {{-- Info Escrow --}}
    <div class="flex items-start gap-4 p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100 text-[#4338CA]">
        <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        <div class="text-xs leading-relaxed font-semibold">
            <h4 class="font-bold text-sm mb-1 text-indigo-950">Jaminan Transaksi Aman (Escrow)</h4>
            Dana pembayaran Anda akan ditampung dengan aman oleh sistem MindFlow dan baru akan disalurkan ke saldo honorarium dokter konselor setelah sesi selesai sepenuhnya.
        </div>
    </div>
</div>
@endsection
