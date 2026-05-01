@extends('layouts.dashboard')

@section('title', 'Forum Komunitas - MindFlow')

@section('styles')
<style>
    .thread-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
        transition: all 0.2s;
    }
    .thread-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border-color: #D1D5DB;
    }
    .thread-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
    }
    .thread-meta {
        font-size: 13px;
        color: #6B7280;
    }
    .thread-title {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        margin: 8px 0 6px;
    }
    .thread-content {
        font-size: 15px;
        color: #374151;
        line-height: 1.6;
    }
    .thread-actions {
        display: flex;
        gap: 20px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #F3F4F6;
    }
    .thread-action {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #6B7280;
        cursor: pointer;
        transition: color 0.2s;
    }
    .thread-action:hover { color: var(--primary-purple); }
    .thread-action svg { width: 18px; height: 18px; }
    .btn-new-thread {
        background: linear-gradient(135deg, #7C3AED, #5B21B6);
        color: white;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 15px rgba(91,33,182,0.25);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-new-thread:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 25px rgba(91,33,182,0.35);
    }
    .toast {
        position: fixed;
        top: 32px;
        right: 32px;
        z-index: 2000;
        background: #111827;
        color: #FFFFFF;
        padding: 16px 24px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        animation: toastIn 0.4s ease, toastOut 0.4s ease 3.6s forwards;
    }
    @keyframes toastIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes toastOut { from { opacity: 1; } to { opacity: 0; } }
</style>
@endsection

@section('content')
<div style="max-width: 720px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #111827;">Forum Komunitas</h2>
            <p style="font-size: 14px; color: #6B7280; margin-top: 4px;">Berbagi cerita dan saling mendukung 💜</p>
        </div>
        <a href="{{ route('forum.create') }}" class="btn-new-thread">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Buat Thread
        </a>
    </div>

    @if($threads->isEmpty())
        <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 16px; border: 1px solid #E5E7EB;">
            <div style="font-size: 48px; margin-bottom: 16px;">💬</div>
            <p style="font-size: 16px; font-weight: 600; color: #6B7280;">Belum ada thread. Jadilah yang pertama berbagi!</p>
        </div>
    @else
        @foreach($threads as $thread)
        <div class="thread-card">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($thread->user->nama_samaran ?? 'User') }}&background=E9D8FD&color=5B21B6&size=44" class="thread-avatar" alt="">
                <div>
                    <div style="font-weight: 700; font-size: 14px; color: #111827;">{{ $thread->user->nama_samaran ?? 'Anonim' }}</div>
                    <div class="thread-meta">{{ $thread->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <a href="{{ route('forum.show', $thread->forum_id) }}" style="text-decoration: none;">
                <div class="thread-title">{{ $thread->judul_thread }}</div>
            </a>
            <div class="thread-content">{{ Str::limit($thread->konten, 250) }}</div>
            <div class="thread-actions">
                <a href="{{ route('forum.show', $thread->forum_id) }}" class="thread-action">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    {{ $thread->komentars->count() }} Komentar
                </a>
                @if(Auth::check() && $thread->user_id === Auth::id())
                <form action="{{ route('forum.destroy', $thread->forum_id) }}" method="POST" onsubmit="return confirm('Hapus postingan ini?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="thread-action" style="background:none;border:none;cursor:pointer;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    @endif
</div>

@if(session('success'))
<div class="toast" id="toast">✅ {{ session('success') }}</div>
<script>setTimeout(() => document.getElementById('toast')?.remove(), 4200);</script>
@endif
@endsection
