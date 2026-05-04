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

    <div class="thread-header" style="position: relative;">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? '9ca3af' : 'd1d5db' }}&color=1f2937" 
                 alt="Avatar" class="thread-avatar {{ $isAnon ? 'anon' : 'real' }}">
        <div>
            <div class="author-name">{{ $authorName }} <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span></div>
            <div class="post-time">{{ $thread->created_at->format('h:i A · M d, Y') }}</div>
        </div>

        <div class="thread-menu" style="position:absolute; right:0; top:0;">
            <button onclick="document.getElementById('dropdown-show-{{ $thread->id }}').style.display = document.getElementById('dropdown-show-{{ $thread->id }}').style.display === 'none' ? 'block' : 'none';" style="background:transparent; border:none; cursor:pointer; color:var(--text-muted);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
            </button>
            
            <!-- Dropdown Content -->
            <div id="dropdown-show-{{ $thread->id }}" style="display:none; position:absolute; right:0; top:28px; background:white; border:1px solid var(--border-dark); border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1); z-index:10; min-width:150px; padding:8px 0; font-family:inherit;">
                @if($thread->user_id === Auth::id())
                    <form action="{{ route('forum.destroy', $thread->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Hapus post ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width:100%; text-align:left; background:none; border:none; padding:8px 16px; cursor:pointer; color:#ef4444; font-size:0.9rem;">Hapus Post</button>
                    </form>
                @elseif(Auth::user()->role !== 'admin')
                    <button onclick="document.getElementById('report-post-show-{{ $thread->id }}').style.display='block'; document.getElementById('dropdown-show-{{ $thread->id }}').style.display='none';" style="width:100%; text-align:left; background:none; border:none; padding:8px 16px; cursor:pointer; color:var(--text-main); font-size:0.9rem;">Laporkan</button>
                @endif
            </div>

            @if(Auth::user()->role !== 'admin')
            <!-- Report Form -->
            <form id="report-post-show-{{ $thread->id }}" action="{{ route('forum.report', $thread->id) }}" method="POST" style="display:none; position:absolute; right:0; top:28px; background:white; border:1px solid #ef4444; border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1); z-index:11; padding:12px; width:240px; font-family:inherit;">
                @csrf
                <div style="font-weight:600; font-size:0.85rem; margin-bottom:8px; color:#ef4444;">Laporkan Postingan</div>
                <input type="text" name="reason" placeholder="Contoh: Spam, Mengganggu..." style="width:100%; padding:6px 8px; border:1px solid var(--border-dark); border-radius:4px; margin-bottom:8px; font-size:0.85rem;" required>
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" onclick="document.getElementById('report-post-show-{{ $thread->id }}').style.display='none'" style="background:none; border:none; font-size:0.8rem; cursor:pointer; color:var(--text-muted); font-weight:600;">Batal</button>
                    <button type="submit" style="background:#ef4444; color:white; border:none; padding:4px 12px; border-radius:4px; font-weight:600; font-size:0.8rem; cursor:pointer;">Kirim</button>
                </div>
            </form>
            @endif
        </div>
    </div>

    <div class="thread-body">{{ $thread->content }}</div>

    @php
        $currentUserRole = Auth::user()->role ?? 'user';
        $isCurrentUserAnon = $currentUserRole === 'user';
        $currentName = $isCurrentUserAnon ? 'User Anonim' : (Auth::user()->nama_asli ?? 'User');
        $currentUserBadgeClass = $currentUserRole === 'admin' ? 'badge-admin' : ($currentUserRole === 'konselor' ? 'badge-konselor' : 'badge-user');
        $currentUserBadgeText = $currentUserRole === 'admin' ? 'Admin' : ($currentUserRole === 'konselor' ? 'Dokter' : 'Anonim');
    @endphp
    <div style="font-weight: 600; font-size: 0.95rem; margin-top: 16px; margin-bottom: -4px; color: var(--text-main);">
        Membalas sebagai: {{ $currentName }} <span class="badge {{ $currentUserBadgeClass }}">{{ $currentUserBadgeText }}</span>
    </div>
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
