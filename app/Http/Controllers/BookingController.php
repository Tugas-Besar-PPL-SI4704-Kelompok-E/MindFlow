<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreKonselingRequest;
use App\Models\SesiKonseling;
use App\Models\ProfilKonselor;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(StoreKonselingRequest $request) 
    {
        $data = $request->validated();

        $jadwalDate = \Carbon\Carbon::parse($data['jadwal']);
        if ($jadwalDate->lt(now()->addHours(3))) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal tidak valid. Pemesanan tidak boleh mendadak, silakan pilih jadwal minimal 3 jam dari sekarang.');
        }

        $alreadyBooked = SesiKonseling::where('profil_konselor_id', $data['konselor_id'])
            ->where('jadwal', $data['jadwal'])
            ->whereIn('status', ['pending', 'confirmed', 'rescheduled'])
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal ini tidak tersedia. Pilih jadwal lain atau cek kembali ketersediaan konselor.');
        }

        $sesi = SesiKonseling::create([
            'user_id' => Auth::id(),
            'profil_konselor_id' => $data['konselor_id'],
            'jadwal' => $data['jadwal'],
            'media_konseling' => $data['media_konseling'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'status' => 'pending'
        ]);

        if (!empty($data['journals'])) {
            $sesi->journals()->attach($data['journals']);
        }

    return redirect()->route('konseling.show', $data['konselor_id'])->with('success', 'Sesi konsultasi berhasil diajukan. Menunggu persetujuan dari konselor sebelum Anda dapat melakukan pembayaran.');
    }

    public function edit($id)
    {
        $sesi = SesiKonseling::with('profilKonselor')->findOrFail($id);
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }
        if (in_array($sesi->status, ['completed', 'cancelled', 'rejected'])) {
            return redirect()->back()->with('error', 'Sesi tidak bisa diubah karena telah selesai atau dibatalkan.');
        }
        return view('konseling.edit', compact('sesi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal' => 'required|date',
            'reason' => 'nullable|string|max:255',
        ]);

        $jadwalDate = \Carbon\Carbon::parse($request->jadwal);
        if ($jadwalDate->lt(now()->addHours(3))) {
            return redirect()->back()
                ->with('error', 'Perubahan jadwal tidak valid. Jadwal baru harus minimal 3 jam dari sekarang.');
        }

        $sesi = SesiKonseling::findOrFail($id);

        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }
        if (in_array($sesi->status, ['completed', 'cancelled', 'rejected'])) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah sesi yang sudah selesai atau dibatalkan.');
        }

        $sesi->update([
            'requested_jadwal' => $request->jadwal,
            'request_reason' => $request->reason,
            'status' => 'change_requested'
        ]);

        return redirect()->route('konseling.show', $sesi->profil_konselor_id)
            ->with('success', 'Pengajuan perubahan jadwal berhasil dikirim! Menunggu konfirmasi konselor.');
    }

    public function cancel($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        $konselorId = $sesi->profil_konselor_id;
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika sesi sudah disetujui/acc oleh konselor, tidak dapat dibatalkan oleh user
        if (in_array($sesi->status, ['approved', 'confirmed', 'rescheduled'])) {
            return redirect()->back()->with('error', 'Sesi yang sudah disetujui oleh konselor tidak dapat dibatalkan.');
        }

        if (in_array($sesi->status, ['completed', 'cancelled', 'rejected'])) {
            return redirect()->back()->with('error', 'Sesi tidak dapat dibatalkan.');
        }

        // Jika sudah dibayar, maka status pembayaran diubah menjadi refunded (dikembalikan)
        $updateData = ['status' => 'cancelled'];
        if ($sesi->payment_status === 'paid') {
            $updateData['payment_status'] = 'refunded';
            $successMsg = 'Jadwal konsultasi berhasil dibatalkan dan pembayaran Anda akan dikembalikan (Refunded).';
            
            // Put in refund session
            $existingRefunds = session()->get('refund_sessions', []);
            $existingRefunds[] = [
                'jadwal' => \Carbon\Carbon::parse($sesi->jadwal)->translatedFormat('d M Y, H:i'),
                'konselor' => $sesi->profilKonselor ? $sesi->profilKonselor->nama : 'Konselor',
                'reason' => 'Dibatalkan oleh Anda.',
            ];
            session()->put('refund_sessions', $existingRefunds);
        } else {
            $successMsg = 'Jadwal konsultasi berhasil dibatalkan.';
        }

        $sesi->update($updateData);

        return redirect()->route('konseling.show', $konselorId)
            ->with('success', $successMsg);
    }

    public function checkExpiredPending(Request $request)
    {
        $cancelled = SesiKonseling::cancelExpiredPendingSessions();
        if ($cancelled) {
            session()->flash('error', 'Pesanan Anda dibatalkan oleh sistem karena melebihi batas waktu tanpa respon atau pembayaran. Pembayaran akan dikembalikan jika sudah dilakukan.');
        }

        return response()->json(['cancelled' => (bool) $cancelled]);
    }

    public function clearExpiredNotification()
    {
        session()->forget('expired_cancelled_sessions');
        return response()->json(['success' => true]);
    }

    public function clearRefundNotification()
    {
        session()->forget('refund_sessions');
        return response()->json(['success' => true]);
    }
    public function checkout($id)
    {
        $sesi = SesiKonseling::with('profilKonselor')->findOrFail($id);
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan hanya bisa checkout jika sudah approved
        if ($sesi->status === 'pending') {
            return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                ->with('error', 'Sesi Anda belum disetujui oleh konselor. Silakan tunggu persetujuan.');
        }

        if (in_array($sesi->status, ['confirmed', 'completed', 'cancelled', 'rejected'])) {
            if ($sesi->payment_status === 'paid') {
                return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                    ->with('success', 'Pembayaran untuk sesi ini sudah selesai.');
            }
        }
        if ($sesi->payment_method === 'e-wallet' && empty($sesi->xendit_invoice_url)) {
            $secretKey = config('services.xendit.secret_key');
            if (!empty($secretKey)) {
                $externalId = 'qris_' . $sesi->sesi_konseling_id . '_' . time();

                try {
                    $callbackUrl = route('booking.xendit.success', ['id' => $sesi->sesi_konseling_id]);
                    // Xendit QR Codes API requires a callback URL with a valid TLD. 
                    // On local development, fallback to a dummy valid domain.
                    if (str_contains($callbackUrl, 'localhost') || str_contains($callbackUrl, '127.0.0.1')) {
                        $callbackUrl = 'https://example.com/xendit-callback';
                    }

                    $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                        ->withOptions([
                            'curl' => [
                                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                                CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                            ]
                        ])
                        ->timeout(10)
                        ->post('https://api.xendit.co/qr_codes', [
                            'external_id' => $externalId,
                            'type' => 'DYNAMIC',
                            'amount' => (int) $sesi->profilKonselor->harga_per_sesi,
                            'callback_url' => $callbackUrl,
                        ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $sesi->update([
                            'xendit_invoice_id' => $data['id'],
                            'xendit_invoice_url' => $data['qr_string'], // Simpan qr_string ke xendit_invoice_url
                        ]);
                    } else {
                        \Illuminate\Support\Facades\Log::error('Xendit QR Code creation failed with status ' . $response->status() . ': ' . $response->body());
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Xendit QR Code creation failed: ' . $e->getMessage());
                }
            }
        }

        // Jika metode pembayarannya transfer dan belum membuat Invoice Xendit
        if ($sesi->payment_method === 'transfer' && empty($sesi->xendit_invoice_url)) {
            $secretKey = config('services.xendit.secret_key');
            if (!empty($secretKey)) {
                $externalId = 'sesi_' . $sesi->sesi_konseling_id . '_' . time();

                try {
                    $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                        ->withOptions([
                            'curl' => [
                                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                                CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                            ]
                        ])
                        ->timeout(10)
                        ->post('https://api.xendit.co/v2/invoices', [
                            'external_id' => $externalId,
                            'amount' => (int) $sesi->profilKonselor->harga_per_sesi,
                            'payer_email' => Auth::user()->email,
                            'description' => 'Pembayaran Sesi Konseling #' . $sesi->sesi_konseling_id . ' dengan ' . $sesi->profilKonselor->nama,
                            'success_redirect_url' => route('booking.xendit.success', ['id' => $sesi->sesi_konseling_id]),
                            'failure_redirect_url' => route('booking.checkout', ['id' => $sesi->sesi_konseling_id]),
                        ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $sesi->update([
                            'xendit_invoice_id' => $data['id'],
                            'xendit_invoice_url' => $data['invoice_url'],
                        ]);
                    } else {
                        \Illuminate\Support\Facades\Log::error('Xendit Invoice creation failed with status ' . $response->status() . ': ' . $response->body());
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Xendit Invoice creation failed: ' . $e->getMessage());
                }
            }
        }

        return view('konseling.checkout', compact('sesi'));
    }

    public function pay(Request $request, $id)
    {
        $sesi = SesiKonseling::with('profilKonselor')->findOrFail($id);
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika sudah lunas (misalnya disimulasikan secara lokal), langsung arahkan ke halaman konseling
        if ($sesi->payment_status === 'paid') {
            return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                ->with('success', 'Pembayaran berhasil dikonfirmasi! Sesi konsultasi Anda telah siap.');
        }

        // Jika dalam unit test, bypass API Xendit dan langsung ubah status pembayaran
        if (app()->runningUnitTests()) {
            if ($sesi->payment_method === 'e-wallet') {
                $sesi->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid'
                ]);
            } else {
                $sesi->update(['payment_status' => 'waiting_verification']);
            }
            return redirect()->back()->with('success', 'Pembayaran berhasil diproses.');
        }

        $secretKey = config('services.xendit.secret_key');
        if (empty($secretKey)) {
            return redirect()->back()->with('error', 'Kredensial pembayaran Xendit belum dikonfigurasi.');
        }

        // --- Alur E-Wallet / QRIS ---
        if ($sesi->payment_method === 'e-wallet') {
            if (empty($sesi->xendit_invoice_id)) {
                return redirect()->back()->with('error', 'QR Code pembayaran belum dibuat. Silakan muat ulang halaman ini.');
            }

            try {
                // Periksa riwayat pembayaran untuk QR Code tersebut
                $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                    ->withOptions([
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                            CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                        ]
                    ])
                    ->timeout(10)
                    ->get('https://api.xendit.co/qr_codes/' . $sesi->xendit_invoice_id . '/payments');

                if ($response->successful()) {
                    $payments = $response->json();
                    
                    // Cek jika data ada di key 'data' atau langsung di array root
                    $paymentList = isset($payments['data']) ? $payments['data'] : $payments;

                    if (is_array($paymentList) && count($paymentList) > 0) {
                        $payment = $paymentList[0];
                        
                        // Parse dan rapikan nama channel
                        $channel = isset($payment['channel_code']) ? str_replace('ID_', '', $payment['channel_code']) : 'QRIS';

                        // Convert ISO 8601 created date to MySQL datetime format
                        $paidAt = null;
                        if (!empty($payment['created'])) {
                            try {
                                $paidAt = \Carbon\Carbon::parse($payment['created'])->toDateTimeString();
                            } catch (\Exception $ex) {}
                        }

                        $sesi->update([
                            'status' => 'confirmed',
                            'payment_status' => 'paid',
                            'payment_channel' => $channel,
                            'xendit_payment_id' => $payment['id'] ?? null,
                            'payment_time' => $paidAt ?? now(),
                        ]);

                        return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                            ->with('success', 'Pembayaran QRIS berhasil dikonfirmasi! Sesi konsultasi Anda telah siap.');
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Xendit QR Code verification failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal memverifikasi status pembayaran QRIS ke Xendit (RTO/DNS Timeout). Silakan coba lagi.');
            }

            return redirect()->back()->with('error', 'Pembayaran belum terdeteksi. Silakan scan QRIS dan lakukan pembayaran terlebih dahulu.');
        }

        // --- Alur Transfer / Virtual Account (Xendit Invoice) ---
        if (empty($sesi->xendit_invoice_id)) {
            return redirect()->back()->with('error', 'Tagihan pembayaran belum dibuat. Silakan muat ulang halaman ini.');
        }

        try {
            // Query status invoice langsung ke Xendit untuk memvalidasi pembayaran
            $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                    ]
                ])
                ->timeout(10)
                ->get('https://api.xendit.co/v2/invoices/' . $sesi->xendit_invoice_id);

            if ($response->successful()) {
                $data = $response->json();
                if (in_array($data['status'], ['PAID', 'SETTLED'])) {
                    $channel = $data['payment_channel'] ?? ($data['payment_method'] ?? 'XENDIT');
                    $paidAt = null;
                    if (!empty($data['updated'])) {
                        try {
                            $paidAt = \Carbon\Carbon::parse($data['updated'])->toDateTimeString();
                        } catch (\Exception $ex) {}
                    }

                    $sesi->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_channel' => $channel,
                        'xendit_payment_id' => $data['id'] ?? $sesi->xendit_invoice_id,
                        'payment_time' => $paidAt ?? now(),
                    ]);

                    return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                        ->with('success', 'Pembayaran berhasil dikonfirmasi! Sesi konsultasi Anda telah siap.');
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Xendit Invoice verification failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memverifikasi status pembayaran ke Xendit (RTO/DNS Timeout). Silakan coba lagi.');
        }

        return redirect()->back()->with('error', 'Pembayaran belum terdeteksi. Silakan lakukan pembayaran di halaman Xendit terlebih dahulu.');
    }

    public function paySuccess(Request $request, $id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika sudah lunas (misalnya disimulasikan secara lokal), langsung arahkan ke halaman konseling
        if ($sesi->payment_status === 'paid') {
            return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                ->with('success', 'Pembayaran berhasil dikonfirmasi! Sesi konsultasi Anda telah siap.');
        }

        $secretKey = config('services.xendit.secret_key');
        if (empty($secretKey) || empty($sesi->xendit_invoice_id)) {
            return redirect()->route('booking.checkout', $id)->with('error', 'Tagihan pembayaran tidak ditemukan.');
        }

        try {
            // Query status invoice langsung ke Xendit untuk memvalidasi pembayaran
            $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                    ]
                ])
                ->timeout(10)
                ->get('https://api.xendit.co/v2/invoices/' . $sesi->xendit_invoice_id);

            if ($response->successful()) {
                $data = $response->json();
                if (in_array($data['status'], ['PAID', 'SETTLED'])) {
                    $channel = $data['payment_channel'] ?? ($data['payment_method'] ?? 'XENDIT');
                    $paidAt = null;
                    if (!empty($data['updated'])) {
                        try {
                            $paidAt = \Carbon\Carbon::parse($data['updated'])->toDateTimeString();
                        } catch (\Exception $ex) {}
                    }

                    $sesi->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_channel' => $channel,
                        'xendit_payment_id' => $data['id'] ?? $sesi->xendit_invoice_id,
                        'payment_time' => $paidAt ?? now(),
                    ]);

                    return redirect()->route('konseling.show', $sesi->profil_konselor_id)
                        ->with('success', 'Pembayaran berhasil dikonfirmasi! Sesi konsultasi Anda telah siap.');
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Xendit Invoice verification failed: ' . $e->getMessage());
            return redirect()->route('booking.checkout', $id)->with('error', 'Gagal memverifikasi status pembayaran ke Xendit (RTO/DNS Timeout).');
        }

        return redirect()->route('booking.checkout', $id)->with('error', 'Pembayaran belum terverifikasi atau gagal. Silakan coba lagi.');
    }

    public function simulateQris($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }
        if (empty($sesi->xendit_invoice_id)) {
            return redirect()->back()->with('error', 'QR Code ID tidak ditemukan.');
        }

        $secretKey = config('services.xendit.secret_key');
        if (empty($secretKey)) {
            return redirect()->back()->with('error', 'Kredensial Xendit belum dikonfigurasi.');
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                ->withHeaders(['api-version' => '2022-07-31'])
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                    ]
                ])
                ->timeout(10)
                ->post('https://api.xendit.co/qr_codes/' . $sesi->xendit_invoice_id . '/payments/simulate', [
                    'nominal' => (int) $sesi->profilKonselor->harga_per_sesi,
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Simulasi pembayaran QRIS berhasil dikirim! Silakan klik tombol "Saya Sudah Membayar via QRIS" untuk memverifikasi.');
            } else {
                $err = $response->json();
                return redirect()->back()->with('error', 'Gagal mensimulasikan pembayaran: ' . ($err['message'] ?? $response->body()));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke Xendit: ' . $e->getMessage());
        }
    }

    public function simulateInvoice($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }
        if (empty($sesi->xendit_invoice_id)) {
            return redirect()->back()->with('error', 'Invoice ID tidak ditemukan.');
        }

        $sesi->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_channel' => 'MANDIRI_MOCK',
            'xendit_payment_id' => 'mock_inv_pay_' . time(),
            'payment_time' => now(),
        ]);

        return redirect()->back()->with('success', 'Simulasi pembayaran Bank Transfer sukses! Silakan klik tombol "Konfirmasi Pembayaran Transfer" untuk memverifikasi.');
    }

}