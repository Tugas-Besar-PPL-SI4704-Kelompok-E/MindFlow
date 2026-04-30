@extends('layouts.dashboard')

@section('title', 'Detail Thread - MindFlow Forum')

@section('styles')
<style>
    .detail-card { background: #fff; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px; margin-bottom: 24px; }
    .comment-card { background: #F9FAFB; border: 1px solid #F3F4F6; border-radius: 12px; padding: 16px; margin-bottom: 12px; }
    .btn-primary { background: linear-gradient(135deg, #7C3AED, #5B21B6); color: white; padding: 10px 24px; border-radius: 10px; font-weight: 700; font-size: 14px; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(91,33,182,0.3); }
    .btn-outline { background: transparent; color: #DC2626; padding: 10px 24px; border-radius: 10px; font-weight: 700; font-size: 14px; border: 1.5px solid #FCA5A5; cursor: pointer; transition: all 0.2s; }
    .btn-outline:hover { background: #FEF2F2; }
    .form-textarea { width: 100%; padding: 14px; border: 1.5px solid #E5E7EB; border-radius: 12px; font-size: 14px; resize: none; outline: none; transition: border 0.2s; font-family: inherit; }
    .form-textarea:focus { border-color: #7C3AED; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
    .toast { position: fixed; top: 32px; right: 32px; z-index: 2000; background: #111827; color: #FFF; padding: 16px 24px; border-radius: 14px; font-size: 14px; font-weight: 500; animation: toastIn 0.4s ease, toastOut 0.4s ease 3.6s forwards; }
    @keyframes toastIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes toastOut { from { opacity: 1; } to { opacity: 0; } }
</style>
@endsection

@section('content')
<div style="max-width: 720px; margin: 0 auto;">
    <!-- Back -->
    <a href="{{ route('forum.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: #6B7280; margin-bottom: 20px; text-decoration: none;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Forum
    </a>

    <!-- Thread Detail -->
    <div class="detail-card">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($thread->user->nama_samaran ?? 'User') }}&background=E9D8FD&color=5B21B6&size=48" style="width:48px;height:48px;border-radius:50%;" alt="">
            <div>
                <div style="font-weight: 700; font-size: 15px; color: #111827;">{{ $thread->user->nama_samaran ?? 'Anonim' }}</div>
                <div style="font-size: 13px; color: #6B7280;">{{ $thread->created_at->translatedFormat('d M Y, H:i') }}</div>
            </div>
        </div>
        <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin-bottom: 12px;">{{ $thread->judul_thread }}</h2>
        <p style="font-size: 15px; color: #374151; line-height: 1.7; white-space: pre-line;">{{ $thread->konten }}</p>

        <!-- Report Button -->
        @auth
        <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #F3F4F6;">
            <details style="cursor: pointer;">
                <summary style="font-size: 13px; font-weight: 600; color: #DC2626; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Laporkan Postingan
                </summary>
                <form action="{{ route('forum.report', $thread->forum_id) }}" method="POST" style="margin-top: 12px;">
                    @csrf
                    <select name="alasan_laporan" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 14px; margin-bottom: 10px; outline: none;">
                        <option value="">-- Pilih Alasan --</option>
                        <option value="Ujaran Kebencian & Pelecehan">Ujaran Kebencian & Pelecehan</option>
                        <option value="Spam / Promosi Ilegal">Spam / Promosi Ilegal</option>
                        <option value="Konten Tidak Pantas">Konten Tidak Pantas</option>
                        <option value="Informasi Menyesatkan">Informasi Menyesatkan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <button type="submit" class="btn-outline">Kirim Laporan</button>
                </form>
            </details>
        </div>
        @endauth
    </div>

    <!-- Komentar Section -->
    <div style="margin-bottom: 20px;">
        <h3 style="font-size: 17px; font-weight: 700; color: #111827; margin-bottom: 16px;">
            💬 Komentar ({{ $thread->komentars->count() }})
        </h3>

        @forelse($thread->komentars as $komentar)
        <div class="comment-card">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($komentar->user->nama_samaran ?? 'User') }}&background=DBEAFE&color=1E40AF&size=32" style="width:32px;height:32px;border-radius:50%;" alt="">
                <div>
                    <span style="font-weight: 700; font-size: 13px; color: #111827;">{{ $komentar->user->nama_samaran ?? 'Anonim' }}</span>
                    <span style="font-size: 12px; color: #9CA3AF; margin-left: 8px;">{{ $komentar->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <p style="font-size: 14px; color: #374151; line-height: 1.6; padding-left: 42px;">{{ $komentar->konten_komentar }}</p>
        </div>
        @empty
        <div style="text-align: center; padding: 40px; background: #F9FAFB; border-radius: 12px; border: 1px solid #F3F4F6;">
            <p style="font-size: 14px; color: #9CA3AF;">Belum ada komentar. Jadilah yang pertama!</p>
        </div>
        @endforelse
    </div>

    <!-- Add Comment Form -->
    @auth
    <div class="detail-card">
        <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin-bottom: 12px;">Tulis Komentar</h4>
        <form action="{{ route('forum.komentar', $thread->forum_id) }}" method="POST">
            @csrf
            <textarea name="konten_komentar" class="form-textarea" rows="3" placeholder="Tulis komentarmu di sini..." required></textarea>
            <div style="display: flex; justify-content: flex-end; margin-top: 12px;">
                <button type="submit" class="btn-primary">Kirim Komentar</button>
            </div>
        </form>
    </div>
    @else
    <div style="text-align: center; padding: 24px; background: #FFF7ED; border: 1px solid #FED7AA; border-radius: 12px;">
        <p style="font-size: 14px; color: #92400E;">Silakan <a href="{{ route('login') }}" style="font-weight: 700; color: #7C3AED;">login</a> untuk berkomentar.</p>
    </div>
    @endauth
</div>

@if(session('success'))
<div class="toast" id="toast">✅ {{ session('success') }}</div>
<script>setTimeout(() => document.getElementById('toast')?.remove(), 4200);</script>
@endif
@endsection
