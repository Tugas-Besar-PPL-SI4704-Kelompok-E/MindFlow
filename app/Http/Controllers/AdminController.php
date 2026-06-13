<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\LaporanForum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * PBI 42: Dashboard metrik — menggunakan data real dari database.
     */
    public function index()
    {
        $totalUsers      = User::where('role', 'user')->count();
        $totalKonselor   = User::where('role', 'konselor')->count();
        $totalReports    = \App\Models\ThreadReport::count() + \App\Models\ReplyReport::count() + \App\Models\ArtikelReport::count();
        $totalThreads    = \App\Models\Thread::count();
        $totalSessions   = \App\Models\SesiKonseling::count();
        $totalJournals   = \App\Models\Journal::count();

        // Pengguna baru per hari (7 hari terakhir)
        $userGrowth = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $userGrowth[] = [
                'label' => $date->translatedFormat('D'),
                'count' => User::whereDate('created_at', $date->toDateString())->count(),
            ];
        }

        // Aktivitas terbaru (gabungan thread & sesi terbaru)
        $recentThreads = \App\Models\Thread::with('user')->latest()->take(5)->get();

        $threadReports = \App\Models\ThreadReport::with(['thread' => function($q) { $q->withTrashed(); }, 'thread.user', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($r) {
                return (object)[
                    'type' => 'thread',
                    'id' => $r->id,
                    'target_id' => $r->thread_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->thread ? $r->thread->user : null,
                    'konten' => $r->thread ? $r->thread->content : 'Postingan telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                ];
            });

        $replyReports = \App\Models\ReplyReport::with(['reply' => function($q) { $q->withTrashed(); }, 'reply.user', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($r) {
                return (object)[
                    'type' => 'reply',
                    'id' => $r->id,
                    'target_id' => $r->thread_reply_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->reply ? $r->reply->user : null,
                    'konten' => $r->reply ? $r->reply->content : 'Balasan telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                ];
            });

        $artikelReports = \App\Models\ArtikelReport::with(['artikel', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($r) {
                return (object)[
                    'type' => 'artikel',
                    'id' => $r->id,
                    'target_id' => $r->artikel_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->artikel ? $r->artikel->admin : null,
                    'konten' => $r->artikel ? $r->artikel->judul : 'Artikel telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                ];
            });

        $recentReports = $threadReports->concat($replyReports)->concat($artikelReports)->sortByDesc('created_at')->take(5);

        $data = compact(
            'totalUsers', 'totalKonselor', 'totalReports',
            'totalThreads', 'totalSessions', 'totalJournals',
            'userGrowth', 'recentThreads', 'recentReports'
        );

        return view('admin.dashboard', $data);
    }

    /**
     * PBI 38: Laporan pelanggaran — menggunakan data real dari database.
     */
    public function laporan()
    {
        $threadReports = \App\Models\ThreadReport::with(['thread' => function($q) { $q->withTrashed(); }, 'thread.user', 'user'])
            ->get()
            ->filter(function($r) {
                $isTrashed = $r->thread && $r->thread->trashed();
                $isMuted = $r->thread && $r->thread->user && $r->thread->user->status === 'muted' && \Carbon\Carbon::parse($r->thread->user->muted_until)->isFuture();
                
                // Hapus laporan dan postingan dari DB secara PERMANEN jika postingan sudah di-soft-delete dan user tidak di-mute
                if ($isTrashed && !$isMuted) {
                    if ($r->thread) {
                        $r->thread->forceDelete(); // Ini akan memicu cascade delete pada laporan
                    } else {
                        $r->delete();
                    }
                    return false;
                }
                return true;
            })
            ->map(function($r) {
                return (object)[
                    'type' => 'thread',
                    'id' => $r->id,
                    'target_id' => $r->thread_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->thread ? $r->thread->user : null,
                    'konten' => $r->thread ? $r->thread->content : 'Postingan telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                    'is_deleted' => $r->thread ? $r->thread->trashed() : true
                ];
            });

        $replyReports = \App\Models\ReplyReport::with(['reply' => function($q) { $q->withTrashed(); }, 'reply.user', 'user'])
            ->get()
            ->filter(function($r) {
                $isTrashed = $r->reply && $r->reply->trashed();
                $isMuted = $r->reply && $r->reply->user && $r->reply->user->status === 'muted' && \Carbon\Carbon::parse($r->reply->user->muted_until)->isFuture();
                
                if ($isTrashed && !$isMuted) {
                    if ($r->reply) {
                        $r->reply->forceDelete();
                    } else {
                        $r->delete();
                    }
                    return false;
                }
                return true;
            })
            ->map(function($r) {
                return (object)[
                    'type' => 'reply',
                    'id' => $r->id,
                    'target_id' => $r->thread_reply_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->reply ? $r->reply->user : null,
                    'konten' => $r->reply ? $r->reply->content : 'Balasan telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                    'is_deleted' => $r->reply ? $r->reply->trashed() : true
                ];
            });

        $artikelReports = \App\Models\ArtikelReport::with(['artikel', 'user'])
            ->get()
            ->map(function($r) {
                return (object)[
                    'type' => 'artikel',
                    'id' => $r->id,
                    'target_id' => $r->artikel_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->artikel ? $r->artikel->admin : null,
                    'konten' => $r->artikel ? $r->artikel->judul : 'Artikel telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                    'is_deleted' => $r->artikel ? false : true
                ];
            });

        $reports = $threadReports->concat($replyReports)->concat($artikelReports)->sortByDesc('created_at');

        return view('admin.laporan', compact('reports'));
    }

    /**
     * PBI 40: Eksekusi hapus postingan forum secara permanen.
     */
    public function hapusPostingan(Request $request, $id)
    {
        $type = $request->query('type', 'thread');
        
        if ($type === 'reply') {
            $reply = \App\Models\ThreadReply::findOrFail($id);
            $reply->delete();
            return back()->with('success', "Balasan telah dihapus secara permanen.");
        } else {
            $thread = \App\Models\Thread::findOrFail($id);
            $thread->delete();
            return back()->with('success', "Postingan telah dihapus secara permanen.");
        }
    }

    /**
     * Hapus artikel secara permanen dari panel admin.
     */
    public function hapusArtikel($id)
    {
        $artikel = \App\Models\Artikel::findOrFail($id);
        $artikel->delete();
        return back()->with('success', "Artikel berhasil dihapus secara permanen.");
    }

    /**
     * Hapus/Abaikan laporan artikel secara permanen.
     */
    public function hapusLaporanArtikel($id)
    {
        $report = \App\Models\ArtikelReport::findOrFail($id);
        $report->delete();
        return back()->with('success', "Laporan artikel berhasil diabaikan.");
    }

    /**
     * Hapus/Abaikan laporan forum (thread) secara permanen.
     */
    public function hapusLaporanForum($id)
    {
        $report = \App\Models\ThreadReport::findOrFail($id);
        $report->delete();
        return back()->with('success', "Laporan forum berhasil diabaikan.");
    }

    /**
     * Hapus/Abaikan laporan balasan secara permanen.
     */
    public function hapusLaporanReply($id)
    {
        $report = \App\Models\ReplyReport::findOrFail($id);
        $report->delete();
        return back()->with('success', "Laporan balasan berhasil diabaikan.");
    }

    /**
     * PBI 41: Menjatuhkan hukuman kepada pengguna.
     */
    public function punishUser(Request $request, $id)
    {
        $request->validate([
            'punishment_type' => 'required|in:mute',
            'duration' => 'required|integer|min:1',
            'reason' => 'required|string|max:1000'
        ]);

        $user = \App\Models\User::findOrFail($id);
        
        if ($request->punishment_type === 'mute') {
            $user->update([
                'status' => 'muted',
                'muted_until' => now()->addHours((int) $request->duration),
                'punishment_reason' => $request->reason
            ]);
        }

        return back()->with('success', 'Hukuman berhasil dijatuhkan kepada pengguna');
    }

    /**
     * PBI 37: Page rekrutmen aplikan — data real dari database.
     */
    public function rekrutmen()
    {
        // Ambil semua user konselor beserta profil mereka
        $applicants = User::where('role', 'konselor')
            ->with('profilKonselor')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.rekrutmen', compact('applicants'));
    }

    /**
     * Approve aplikan konselor — ubah status menjadi approved.
     */
    public function approveKonselor($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        return back()->with('success', 'Konselor ' . $user->nama_asli . ' berhasil diverifikasi!');
    }

    /**
     * Reject aplikan konselor — ubah status menjadi rejected.
     */
    public function rejectKonselor($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'Aplikan ' . $user->nama_asli . ' telah ditolak.');
    }

    /**
     * PBI 39: Pengelolaan kategori spesialisasi konselor — tampilkan data dari database.
     */
    public function spesialisasi()
    {
        $spesialisasis = \App\Models\Spesialisasi::orderBy('nama')->get();

        return view('admin.spesialisasi', compact('spesialisasis'));
    }

    /**
     * PBI 39: Tambah spesialisasi baru.
     */
    public function storeSpesialisasi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:spesialisasis,nama',
        ]);

        \App\Models\Spesialisasi::create(['nama' => $request->nama]);

        return back()->with('success', 'Spesialisasi "' . $request->nama . '" berhasil ditambahkan!');
    }

    /**
     * PBI 39: Update nama spesialisasi.
     */
    public function updateSpesialisasi(Request $request, $id)
    {
        $spesialisasi = \App\Models\Spesialisasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100|unique:spesialisasis,nama,' . $id,
        ]);

        $spesialisasi->update(['nama' => $request->nama]);

        return back()->with('success', 'Spesialisasi berhasil diperbarui!');
    }

    /**
     * PBI 39: Toggle status aktif/nonaktif spesialisasi.
     */
    public function toggleSpesialisasi($id)
    {
        $spesialisasi = \App\Models\Spesialisasi::findOrFail($id);
        $spesialisasi->update(['is_active' => !$spesialisasi->is_active]);

        $status = $spesialisasi->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', 'Spesialisasi "' . $spesialisasi->nama . '" berhasil ' . $status . '!');
    }

    /**
     * PBI 39: Hapus spesialisasi.
     */
    public function destroySpesialisasi($id)
    {
        $spesialisasi = \App\Models\Spesialisasi::findOrFail($id);
        $nama = $spesialisasi->nama;
        $spesialisasi->delete();

        return back()->with('success', 'Spesialisasi "' . $nama . '" berhasil dihapus!');
    }

    /**
     * PBI 62: Pengaturan Akun dan Sistem Admin
     */
    public function settings()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_asli' => 'required|string|max:255',
            'nama_samaran' => 'required|string|max:255|unique:users,nama_samaran,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->nama_asli = $request->nama_asli;
        $user->nama_samaran = $request->nama_samaran;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Pengaturan admin berhasil diperbarui!');
    }

    /**
     * Pengelolaan FAQ oleh Admin.
     */
    public function faq()
    {
        $faqs = \App\Models\Faq::latest()->get();
        return view('admin.faq', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        \App\Models\Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function updateFaq(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $faq = \App\Models\Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return back()->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroyFaq($id)
    {
        $faq = \App\Models\Faq::findOrFail($id);
        $faq->delete();

        return back()->with('success', 'FAQ berhasil dihapus!');
    }

    public function transaksi()
    {
        $sessions = \App\Models\SesiKonseling::with(['user', 'profilKonselor'])
            ->orderBy('created_at', 'desc')
            ->get();

        $withdrawals = \App\Models\Transaction::where('type', 'withdrawal')
            ->with('profilKonselor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transaksi', compact('sessions', 'withdrawals'));
    }

    public function verifyPayment($id)
    {
        $sesi = \App\Models\SesiKonseling::findOrFail($id);
        
        if ($sesi->payment_status !== 'paid') {
            $sesi->update(['payment_status' => 'paid']);
            
            // Jika sesi sudah diselesaikan sebelumnya oleh konselor,
            // berikan honorarium sekarang agar saldonya langsung masuk.
            if ($sesi->status === 'completed') {
                $profil = $sesi->profilKonselor;
                $amount = $profil->harga_per_sesi ?? 0;
                
                $exists = \App\Models\Transaction::where('sesi_konseling_id', $sesi->sesi_konseling_id)
                    ->where('type', 'deposit')
                    ->exists();
                
                if (!$exists) {
                    \App\Models\Transaction::create([
                        'profil_konselor_id' => $profil->profil_konselor_id,
                        'sesi_konseling_id' => $sesi->sesi_konseling_id,
                        'amount' => $amount,
                        'type' => 'deposit',
                        'status' => 'approved',
                        'description' => 'Honorarium Sesi Konseling #' . $sesi->sesi_konseling_id,
                    ]);

                    $profil->increment('saldo', $amount);
                }
            }
        }

        return back()->with('success', 'Pembayaran sesi konseling #' . $id . ' berhasil diverifikasi!');
    }

    public function approveWithdrawal($id)
    {
        $tx = \App\Models\Transaction::findOrFail($id);
        if ($tx->type !== 'withdrawal' || $tx->status !== 'pending') {
            abort(400);
        }

        $tx->update(['status' => 'approved']);

        return back()->with('success', 'Pengajuan penarikan dana berhasil disetujui!');
    }

    public function rejectWithdrawal($id)
    {
        $tx = \App\Models\Transaction::findOrFail($id);
        if ($tx->type !== 'withdrawal' || $tx->status !== 'pending') {
            abort(400);
        }

        $tx->update(['status' => 'rejected']);

        $profil = $tx->profilKonselor;
        $profil->increment('saldo', $tx->amount);
        return back()->with('success', 'Pengajuan penarikan dana telah ditolak dan saldo dikembalikan ke konselor.');
    }

    public function syncXenditPayments()
    {
        $secretKey = config('services.xendit.secret_key');
        if (empty($secretKey)) {
            return back()->with('error', 'Kredensial Xendit belum dikonfigurasi.');
        }

        // Get all pending sessions that have a Xendit Invoice or QR Code ID
        $pendingSessions = \App\Models\SesiKonseling::where('payment_status', 'pending')
            ->whereNotNull('xendit_invoice_id')
            ->get();

        $updatedCount = 0;

        foreach ($pendingSessions as $sesi) {
            try {
                // If it is QRIS (e-wallet)
                if ($sesi->payment_method === 'e-wallet') {
                    $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                        ->withOptions([
                            'curl' => [
                                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                                CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                            ]
                        ])
                        ->timeout(5)
                        ->get('https://api.xendit.co/qr_codes/' . $sesi->xendit_invoice_id . '/payments');

                    if ($response->successful()) {
                        $payments = $response->json();
                        $paymentList = isset($payments['data']) ? $payments['data'] : $payments;

                        if (is_array($paymentList) && count($paymentList) > 0) {
                            $payment = $paymentList[0];
                            $channel = isset($payment['channel_code']) ? str_replace('ID_', '', $payment['channel_code']) : 'QRIS';
                            
                            $paidAt = null;
                            if (!empty($payment['created'])) {
                                try {
                                    $paidAt = \Carbon\Carbon::parse($payment['created'])->toDateTimeString();
                                } catch (\Exception $ex) {}
                            }

                            $sesi->update([
                                'payment_status' => 'paid',
                                'payment_channel' => $channel,
                                'xendit_payment_id' => $payment['id'] ?? null,
                                'payment_time' => $paidAt ?? now(),
                            ]);
                            $updatedCount++;
                        }
                    }
                } 
                // If it is Bank Transfer / Virtual Account (Xendit Invoice)
                else {
                    $response = \Illuminate\Support\Facades\Http::withBasicAuth($secretKey, '')
                        ->withOptions([
                            'curl' => [
                                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                                CURLOPT_RESOLVE => ['api.xendit.co:443:104.19.160.99,104.19.159.99']
                            ]
                        ])
                        ->timeout(5)
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
                                'payment_status' => 'paid',
                                'payment_channel' => $channel,
                                'xendit_payment_id' => $data['id'] ?? $sesi->xendit_invoice_id,
                                'payment_time' => $paidAt ?? now(),
                            ]);
                            $updatedCount++;
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Sync Xendit failed for session ' . $sesi->sesi_konseling_id . ': ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Sinkronisasi selesai! ' . $updatedCount . ' transaksi berhasil diperbarui.');
    }
}