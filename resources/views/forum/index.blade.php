@extends('layouts.app')

@section('content')

<style>
    .editor-section {
        padding: 24px;
        border-bottom: 8px solid var(--border); /* Thick separator */
    }
    
    .editor-body {
        display: flex;
        gap: 16px;
    }
    
    .editor-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #d1d5db;
        flex-shrink: 0;
        object-fit: cover;
    }

    .editor-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .editor-input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 1.05rem;
        color: var(--text-main);
        resize: none;
        padding-top: 12px;
        font-family: inherit;
        background: transparent;
    }

    .editor-input::placeholder {
        color: #9ca3af;
    }

    .editor-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
    }

    .editor-actions {
        display: flex;
        gap: 12px;
        color: var(--primary);
    }
    
    .editor-icon {
        width: 20px;
        height: 20px;
        cursor: pointer;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
    }

    .btn-posting {
        background-color: var(--primary);
        color: white;
        padding: 8px 24px;
        border-radius: 9999px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .thread-feed {
        display: flex;
        flex-direction: column;
    }

    .thread-item {
        padding: 24px;
        border-bottom: 1px solid var(--border-dark);
        display: flex;
        gap: 16px;
        position: relative;
    }

    .thread-item:hover {
        background-color: #f9fafb;
    }

    .thread-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    
    .thread-avatar.anon {
        background-color: #9ca3af;
    }
    
    .thread-avatar.real {
        background-color: #d1d5db;
    }

    .thread-body {
        flex: 1;
        min-width: 0;
    }

    .thread-top {
        display: flex;
        align-items: center;
        margin-bottom: 4px;
    }

    .thread-author {
        font-weight: 700;
        color: var(--text-main);
        margin-right: 8px;
        font-size: 0.95rem;
    }

    .thread-time {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .thread-menu {
        position: absolute;
        right: 24px;
        top: 24px;
        color: var(--text-muted);
        cursor: pointer;
    }

    .badge {
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 8px;
        vertical-align: middle;
    }
    .badge-admin { background-color: #fef08a; color: #854d0e; }
    .badge-konselor { background-color: #bfdbfe; color: #1e40af; }
    .badge-user { background-color: #e2e8f0; color: #475569; }

    .thread-text {
        font-size: 0.95rem;
        line-height: 1.5;
        color: var(--text-main);
        white-space: pre-wrap;
        margin-bottom: 16px;
    }

    .thread-stats {
        display: flex;
        gap: 24px;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    
    .stat-item:hover {
        color: var(--primary);
    }

    .stat-icon {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        stroke-width: 1.5;
        fill: none;
    }

    .emoji-picker-container {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 8px;
        z-index: 50;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
    }

    emoji-picker {
        width: 320px;
        height: 350px;
        --background: #ffffff;
        --border-color: var(--border-dark);
        --input-border-color: var(--border-dark);
    }
</style>

<div class="editor-section">
    <form action="{{ route('forum.store') }}" method="POST">
        @csrf
        <div class="editor-body">
            @php
                $currentUserRole = Auth::user()->role ?? 'user';
                $isCurrentUserAnon = $currentUserRole === 'user';
            @endphp
            <img src="https://ui-avatars.com/api/?name={{ urlencode($isCurrentUserAnon ? 'User Anonim' : Auth::user()->nama_asli) }}&background={{ $isCurrentUserAnon ? '9ca3af' : 'd1d5db' }}&color=1f2937" 
                 alt="Avatar" class="editor-avatar">
            
            <div class="editor-content">
                <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 8px; color: var(--text-main);">
                    Posting sebagai: {{ $isCurrentUserAnon ? 'User Anonim' : Auth::user()->nama_asli }}
                    @php
                        $currentUserBadgeClass = '';
                        $currentUserBadgeText = '';
                        if ($currentUserRole === 'admin') {
                            $currentUserBadgeClass = 'badge-admin';
                            $currentUserBadgeText = 'Admin';
                        } elseif ($currentUserRole === 'konselor') {
                            $currentUserBadgeClass = 'badge-konselor';
                            $currentUserBadgeText = 'Dokter';
                        } else {
                            $currentUserBadgeClass = 'badge-user';
                            $currentUserBadgeText = 'Anonim';
                        }
                    @endphp
                    <span class="badge {{ $currentUserBadgeClass }}">{{ $currentUserBadgeText }}</span>
                </div>
                <textarea name="content" id="thread-content" class="editor-input" rows="2" placeholder="Ceritakan pengalamanmu!" required></textarea>
                
                @error('content')
                    <div style="color: #ef4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror

                <div class="editor-footer">
                    <div class="editor-actions" style="position: relative;">
                        <!-- Camera Icon -->
                        <svg class="editor-icon" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        
                        <!-- Smile Icon -->
                        <svg id="emoji-button" class="editor-icon" viewBox="0 0 24 24"><path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        
                        <!-- Emoji Picker -->
                        <div id="emoji-picker-container" class="emoji-picker-container">
                            <emoji-picker class="light"></emoji-picker>
                        </div>
                    </div>
                    <button type="submit" class="btn-posting">Posting</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="thread-feed">
    @forelse($threads as $thread)
        <div class="thread-item">
            @php
                $role = $thread->user->role ?? 'user';
                $isAnon = $role === 'user';
                $authorName = $isAnon ? 'User Anonim' : ($thread->user->nama_asli ?? 'User');
                
                $badgeClass = '';
                $badgeText = '';
                if ($role === 'admin') {
                    $badgeClass = 'badge-admin';
                    $badgeText = 'Admin';
                } elseif ($role === 'konselor') {
                    $badgeClass = 'badge-konselor';
                    $badgeText = 'Dokter';
                } else {
                    $badgeClass = 'badge-user';
                    $badgeText = 'Anonim';
                }
            @endphp

            <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? '9ca3af' : 'd1d5db' }}&color=1f2937" 
                 alt="Avatar" class="thread-avatar {{ $isAnon ? 'anon' : 'real' }}">
            
            <div class="thread-body">
                <div class="thread-top">
                    <span class="thread-author">
                        {{ $authorName }}
                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                    </span>
                    <span class="thread-time">{{ $thread->created_at->diffForHumans() }}</span>
                </div>
                
                <div class="thread-text">{{ $thread->content }}</div>
                
                <div class="thread-stats">
                    <a href="{{ route('forum.show', $thread->id) }}" class="stat-item" style="text-decoration: none; color: inherit;">
                        <svg class="stat-icon" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>{{ $thread->replies_count }}</span>
                    </a>
                    
                    <form action="{{ route('forum.like', $thread->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="stat-item" style="background:none; border:none; color: {{ $thread->isLikedBy(Auth::id() ?? 1) ? '#ef4444' : 'inherit' }};">
                            <svg class="stat-icon" viewBox="0 0 24 24" fill="{{ $thread->isLikedBy(Auth::id() ?? 1) ? '#ef4444' : 'none' }}"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>{{ $thread->likes_count }}</span>
                        </button>
                    </form>

                    <form action="{{ route('forum.save', $thread->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="stat-item" style="background:none; border:none; color: {{ $thread->isSavedBy(Auth::id() ?? 1) ? 'var(--primary)' : 'inherit' }};">
                            <svg class="stat-icon" viewBox="0 0 24 24" fill="{{ $thread->isSavedBy(Auth::id() ?? 1) ? 'var(--primary)' : 'none' }}"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>{{ $thread->saves_count }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="thread-menu" style="position: relative;">
                <button onclick="toggleDropdown('dropdown-{{ $thread->id }}')" style="background:transparent; border:none; cursor:pointer; color:var(--text-muted);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </button>
                
                <!-- Dropdown Content -->
                <div id="dropdown-{{ $thread->id }}" style="display:none; position:absolute; right:0; top:32px; background:white; border:1px solid var(--border-dark); border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:100; min-width:160px; padding:4px 0; font-family:inherit;">
                    @if($thread->user_id === Auth::id())
                        <form action="{{ route('forum.destroy', $thread->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Hapus post ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width:100%; text-align:left; background:none; border:none; padding:10px 16px; cursor:pointer; color:#ef4444; font-size:0.9rem; font-weight:500;">🗑️ Hapus Post</button>
                        </form>
                    @elseif(Auth::user()->role !== 'admin')
                        <button onclick="showReportForm('report-post-{{ $thread->id }}', 'dropdown-{{ $thread->id }}')" style="width:100%; text-align:left; background:none; border:none; padding:10px 16px; cursor:pointer; color:#ef4444; font-size:0.9rem; font-weight:500;">⚠️ Laporkan</button>
                    @endif
                </div>

                @if(Auth::user()->role !== 'admin')
                <!-- Report Form Popup -->
                <div id="report-post-{{ $thread->id }}" style="display:none; position:absolute; right:0; top:32px; background:white; border:1px solid #ef4444; border-radius:10px; box-shadow:0 4px 16px rgba(0,0,0,0.15); z-index:101; padding:14px; width:260px; font-family:inherit;">
                    <form action="{{ route('forum.report', $thread->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <div style="font-weight:700; font-size:0.85rem; margin-bottom:8px; color:#ef4444;">⚠️ Laporkan Postingan</div>
                        <input type="text" name="reason" placeholder="Contoh: Spam, Konten Berbahaya..." style="width:100%; padding:8px 10px; border:1px solid #fca5a5; border-radius:6px; margin-bottom:10px; font-size:0.85rem; font-family:inherit; box-sizing:border-box;" required>
                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                            <button type="button" onclick="document.getElementById('report-post-{{ $thread->id }}').style.display='none'" style="background:none; border:1px solid var(--border-dark); border-radius:6px; padding:5px 12px; font-size:0.8rem; cursor:pointer; color:var(--text-muted); font-weight:600;">Batal</button>
                            <button type="submit" style="background:#ef4444; color:white; border:none; border-radius:6px; padding:5px 12px; font-weight:600; font-size:0.8rem; cursor:pointer;">Kirim Laporan</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: var(--text-muted);">
            Belum ada pos di forum ini. Jadilah yang pertama untuk berbagi!
        </div>
    @endforelse
</div>

<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
<script>
    // Toggle dropdown
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        const isVisible = el.style.display === 'block';
        // Close all open dropdowns and report forms first
        document.querySelectorAll('[id^="dropdown-"], [id^="report-post-"]').forEach(d => d.style.display = 'none');
        if (!isVisible) el.style.display = 'block';
    }

    // Show report form and hide dropdown
    function showReportForm(reportId, dropdownId) {
        document.getElementById(dropdownId).style.display = 'none';
        document.getElementById(reportId).style.display = 'block';
    }

    // Close dropdowns and report forms when clicking outside
    document.addEventListener('click', function(e) {
        const isInsideMenu = e.target.closest('[id^="dropdown-"], [id^="report-post-"], .thread-menu');
        if (!isInsideMenu) {
            document.querySelectorAll('[id^="dropdown-"], [id^="report-post-"]').forEach(d => d.style.display = 'none');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const emojiBtn = document.getElementById('emoji-button');
        const emojiPickerContainer = document.getElementById('emoji-picker-container');
        const emojiPicker = document.querySelector('emoji-picker');
        const textarea = document.getElementById('thread-content');
        
        // Toggle picker
        emojiBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (emojiPickerContainer.style.display === 'block') {
                emojiPickerContainer.style.display = 'none';
            } else {
                emojiPickerContainer.style.display = 'block';
            }
        });

        // Listen for emoji selection
        emojiPicker.addEventListener('emoji-click', event => {
            const emoji = event.detail.unicode;
            const cursorPosition = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPosition);
            const textAfter = textarea.value.substring(cursorPosition);
            
            textarea.value = textBefore + emoji + textAfter;
            
            // Focus and set cursor after emoji
            textarea.focus();
            textarea.selectionStart = cursorPosition + emoji.length;
            textarea.selectionEnd = cursorPosition + emoji.length;
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!emojiPickerContainer.contains(e.target) && e.target !== emojiBtn) {
                emojiPickerContainer.style.display = 'none';
            }
        });
    });
</script>

@endsection
