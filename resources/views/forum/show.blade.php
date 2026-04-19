@extends('layouts.app')

@section('content')

<style>
    .thread-show {
        padding: 24px;
        border-bottom: 1px solid var(--border-dark);
    }

    .thread-header {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }

    .thread-avatar {
        width: 48px; height: 48px; border-radius: 50%; margin-right: 12px;
        display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;
    }
    .thread-avatar.anon { background-color: #9ca3af; }
    .thread-avatar.real { background-color: #d1d5db; object-fit: cover; }

    .author-name { font-weight: 700; font-size: 1.05rem; }
    .post-time { font-size: 0.85rem; color: var(--text-muted); }
    .badge { font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; font-weight: 700; text-transform: uppercase; margin-left:8px; vertical-align: middle;}
    .badge-admin { background-color: #fef08a; color: #854d0e; }
    .badge-konselor { background-color: #bfdbfe; color: #1e40af; }
    .badge-user { background-color: #e2e8f0; color: #475569; }

    .thread-body { font-size: 1.1rem; line-height: 1.6; margin-bottom: 16px; white-space: pre-wrap; }

    .reply-form { margin-top: 16px; display: flex; gap: 12px; }
    .reply-input { flex: 1; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border-dark); font-family: inherit; font-size: 0.95rem; }
    .btn-reply { background: var(--primary); color: white; border: none; padding: 0 20px; border-radius: 8px; font-weight: 600; cursor: pointer; }

    .replies-section { padding-top: 12px; }
</style>

<div class="thread-show">
    @php
        $role = $thread->user->role ?? 'user';
        $isAnon = $role === 'user';
        $authorName = $isAnon ? 'User Anonim' : ($thread->user->nama_asli ?? 'User');
        $initial = $isAnon ? '?' : strtoupper(substr($authorName, 0, 1));
        
        $badgeClass = '';
        $badgeText = '';
        if ($role === 'admin') { $badgeClass = 'badge-admin'; $badgeText = 'Admin'; } 
        elseif ($role === 'konselor') { $badgeClass = 'badge-konselor'; $badgeText = 'Dokter'; }
        else { $badgeClass = 'badge-user'; $badgeText = 'Anonim'; }
    @endphp

    <div class="thread-header">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? '9ca3af' : 'd1d5db' }}&color=1f2937" 
                 alt="Avatar" class="thread-avatar {{ $isAnon ? 'anon' : 'real' }}">
        <div>
            <div class="author-name">{{ $authorName }} <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span></div>
            <div class="post-time">{{ $thread->created_at->format('h:i A · M d, Y') }}</div>
        </div>
    </div>

    <div class="thread-body">{{ $thread->content }}</div>

    <form action="{{ route('forum.reply', $thread->id) }}" method="POST" class="reply-form">
        @csrf
        <input type="text" name="content" class="reply-input" placeholder="Balas luapan ini..." required>
        <button type="submit" class="btn-reply">Balas</button>
    </form>
</div>

<div class="replies-section">
    @foreach($replies as $reply)
        @include('forum.partials.reply', ['reply' => $reply, 'depth' => 0])
    @endforeach
</div>

@endsection
