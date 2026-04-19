@php
    $role = $reply->user->role ?? 'user';
    $isAnon = $role === 'user';
    $authorName = $isAnon ? 'User Anonim' : ($reply->user->nama_asli ?? 'User');
    
    $badgeClass = '';
    $badgeText = '';
    if ($role === 'admin') { $badgeClass = 'badge-admin'; $badgeText = 'Admin'; } 
    elseif ($role === 'konselor') { $badgeClass = 'badge-konselor'; $badgeText = 'Dokter'; }
    else { $badgeClass = 'badge-user'; $badgeText = 'Anonim'; }
@endphp

<div class="reply-item" style="margin-top: 16px; margin-left: {{ $depth > 0 ? 32 : 0 }}px; {{ $depth === 0 ? 'padding: 16px 24px; border-bottom: 1px solid var(--border-dark); margin-top:0;' : 'position: relative;' }}">
    @if($depth > 0)
        <!-- Line connector for nested replies -->
        <div style="position: absolute; left: -20px; top: -16px; bottom: 0; width: 2px; background-color: var(--border-dark);"></div>
        <div style="position: absolute; left: -20px; top: 18px; width: 16px; height: 2px; background-color: var(--border-dark);"></div>
    @endif

    <div style="display: flex; gap: 12px;">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? '9ca3af' : 'd1d5db' }}&color=1f2937" 
             alt="Avatar" style="width:36px; height:36px; border-radius:50%; z-index: 1;">
        <div style="flex:1;">
            <div style="font-weight: 600; font-size: 0.95rem;">
                {{ $authorName }} <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                <span style="color:var(--text-muted); font-size:0.8rem; margin-left:6px;">{{ $reply->created_at->diffForHumans() }}</span>
            </div>
            <div style="margin-top: 4px; font-size: 0.95rem; line-height:1.5;">
                {{ $reply->content }}
            </div>
            
            <div style="margin-top: 6px;">
                <button onclick="document.getElementById('reply-form-{{ $reply->id }}').style.display='flex'" style="background:none; border:none; color:var(--text-muted); font-weight:600; font-size:0.8rem; cursor:pointer; display:flex; align-items:center; gap:4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Balas
                </button>
            </div>

            <form id="reply-form-{{ $reply->id }}" action="{{ route('forum.reply', $reply->thread_id) }}" method="POST" style="display:none; margin-top:12px; gap:8px;">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                <input type="text" name="content" style="flex:1; padding:8px 12px; border-radius:6px; border:1px solid var(--border-dark); font-size:0.85rem;" placeholder="Balas ke {{ $authorName }}..." required>
                <button type="submit" class="btn btn-primary" style="padding:4px 12px; font-size:0.8rem;">Kirim</button>
            </form>
        </div>
    </div>
    
    @if($reply->children->isNotEmpty())
        <div style="margin-top: 0px;">
            @foreach($reply->children as $childReply)
                @include('forum.partials.reply', ['reply' => $childReply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>
