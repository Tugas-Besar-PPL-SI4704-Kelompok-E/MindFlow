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

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-100 text-rose-800 px-6 py-4 rounded-2xl mb-8 flex justify-between items-center shadow-sm">
            <span class="font-bold text-sm">{{ session('error') }}</span>
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
                <div class="space-y-4 flex flex-col items-center">
                    <div class="flex items-center gap-3 text-purple-900 font-bold mb-2 self-start w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <span>Pembayaran Transfer Bank / Virtual Account (Xendit)</span>
                    </div>

                    @if($sesi->xendit_invoice_url)
                        {{-- Link Pembayaran Xendit --}}
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-4 w-full">
                            <a href="{{ $sesi->xendit_invoice_url }}" target="_blank" class="px-6 py-3 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-xl font-bold text-sm transition-all active:scale-95 shadow-md flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span>Buka Halaman Pembayaran Xendit</span>
                            </a>
                        </div>
                        <div class="text-xs text-gray-500 leading-relaxed font-semibold text-center max-w-sm">
                            <p class="mb-1">1. Klik tombol di atas untuk membuka tagihan Virtual Account Xendit.</p>
                            <p class="mb-1">2. Lakukan transfer sesuai bank yang Anda pilih di halaman Xendit tersebut.</p>
                            <p>3. Setelah selesai membayar, klik tombol **"Konfirmasi Pembayaran Transfer"** di bawah ini untuk memverifikasi.</p>
                        </div>
                        @if(config('app.env') === 'local')
                            <form action="{{ route('booking.xendit.simulate-invoice', $sesi->sesi_konseling_id) }}" method="POST" class="mt-4 w-full">
                                @csrf
                                <button type="submit" class="w-full py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-xl font-bold text-xs transition-all active:scale-95 flex items-center justify-center gap-1.5 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"></path></svg>
                                    <span>[Sandbox Mode] Simulasikan Pembayaran Bank Transfer</span>
                                </button>
                            </form>
                        @endif
                    @else
                        {{-- Kasus jika gagal memuat dari API Xendit --}}
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-2">
                            <div class="w-48 h-48 bg-red-50/50 border border-red-100 rounded-xl flex items-center justify-center p-6 text-center text-xs text-red-500 font-bold">
                                Gagal memuat tagihan bank transfer secara otomatis.<br>Hubungi admin atau silakan reload halaman.
                            </div>
                        </div>
                        <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-xl font-bold text-xs transition-all active:scale-95 shadow-sm">
                            Muat Ulang Halaman
                        </button>
                    @endif
                </div>
            @else
                <div class="space-y-4 flex flex-col items-center">
                    <div class="flex items-center gap-3 text-purple-900 font-bold mb-2 self-start">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Pembayaran E-Wallet QRIS (Xendit)</span>
                    </div>
                    
                    @if($sesi->xendit_invoice_url)
                        {{-- QR Code Dinamis Xendit --}}
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-2">
                            <div class="w-52 h-52 bg-white border border-gray-100 rounded-xl flex items-center justify-center p-2 shadow-inner">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($sesi->xendit_invoice_url) }}" alt="QRIS Xendit" class="w-full h-full object-contain">
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">MindFlow QRIS Merchant</span>
                        </div>
                        <div class="text-xs text-gray-500 leading-relaxed font-semibold text-center max-w-sm">
                            <p class="mb-1">Pindai QRIS di atas menggunakan aplikasi e-wallet Anda (Gopay/OVO/Dana/LinkAja/M-Banking).</p>
                            <p>Setelah selesai melakukan transfer, klik tombol **"Saya Sudah Membayar via QRIS"** di bawah untuk memverifikasi pembayaran Anda.</p>
                        </div>
                        @if(config('app.env') === 'local')
                            <form action="{{ route('booking.xendit.simulate-qris', $sesi->sesi_konseling_id) }}" method="POST" class="mt-4 w-full">
                                @csrf
                                <button type="submit" class="w-full py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-xl font-bold text-xs transition-all active:scale-95 flex items-center justify-center gap-1.5 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"></path></svg>
                                    <span>[Sandbox Mode] Simulasikan Pembayaran QRIS</span>
                                </button>
                            </form>
                        @endif
                    @else
                        {{-- Kasus jika gagal memuat dari API Xendit --}}
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center gap-2">
                            <div class="w-48 h-48 bg-red-50/50 border border-red-100 rounded-xl flex items-center justify-center p-6 text-center text-xs text-red-500 font-bold">
                                Gagal memuat QRIS secara otomatis.<br>Hubungi admin atau silakan reload halaman.
                            </div>
                        </div>
                        <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 bg-[#A881C2] hover:bg-[#8A64A4] text-white rounded-xl font-bold text-xs transition-all active:scale-95 shadow-sm">
                            Muat Ulang Halaman
                        </button>
                    @endif
                </div>
            @endif
        </div>

        {{-- Form Aksi Bayar --}}
        <form action="{{ route('booking.pay', $sesi->sesi_konseling_id) }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="w-full bg-[#A881C2] hover:bg-[#8A64A4] text-white py-4 rounded-2xl font-bold shadow-lg shadow-purple-500/20 transition-all duration-300 flex items-center justify-center gap-2">
                <span>{{ $sesi->payment_method === 'transfer' ? 'Konfirmasi Pembayaran Transfer' : 'Saya Sudah Membayar via QRIS' }}</span>
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
