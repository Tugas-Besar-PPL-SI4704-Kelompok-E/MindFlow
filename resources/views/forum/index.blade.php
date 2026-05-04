@extends('layouts.app')

@section('content')

<div class="mb-8">
    <div class="bg-white rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100">
        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            <div class="flex gap-4 md:gap-5">
                @php
                    $currentUserRole = Auth::user()->role ?? 'user';
                    $isCurrentUserAnon = $currentUserRole === 'user';
                @endphp
                <div class="flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($isCurrentUserAnon ? 'User Anonim' : Auth::user()->nama_asli) }}&background={{ $isCurrentUserAnon ? 'F3F4F6' : 'E8DEFA' }}&color={{ $isCurrentUserAnon ? '9CA3AF' : '6B3FA0' }}&size=48&bold=true" 
                         alt="Avatar" class="w-12 h-12 rounded-full object-cover border border-gray-100">
                </div>
                
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-sm font-semibold text-gray-600">Posting sebagai: <span class="text-gray-900">{{ $isCurrentUserAnon ? 'User Anonim' : Auth::user()->nama_asli }}</span></span>
                        @php
                            $currentUserBadgeClass = '';
                            $currentUserBadgeText = '';
                            if ($currentUserRole === 'admin') {
                                $currentUserBadgeClass = 'bg-amber-100 text-amber-700';
                                $currentUserBadgeText = 'Admin';
                            } elseif ($currentUserRole === 'konselor') {
                                $currentUserBadgeClass = 'bg-blue-100 text-blue-700';
                                $currentUserBadgeText = 'Dokter';
                            } else {
                                $currentUserBadgeClass = 'bg-gray-100 text-gray-500';
                                $currentUserBadgeText = 'Anonim';
                            }
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-widest {{ $currentUserBadgeClass }}">{{ $currentUserBadgeText }}</span>
                    </div>
                    
                    <textarea name="content" id="thread-content" class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-800 text-[15px] resize-none placeholder-gray-400 mt-1" rows="2" placeholder="Ceritakan pengalamanmu!" required></textarea>
                    
                    @error('content')
                        <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
                    @enderror

                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-50">
                        <div class="flex gap-3 relative">
                            <!-- Camera Icon -->
                            <button type="button" class="text-gray-400 hover:text-[#A881C2] transition-colors p-1.5 rounded-lg hover:bg-purple-50">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            
                            <!-- Smile Icon -->
                            <button type="button" id="emoji-button" class="text-gray-400 hover:text-[#A881C2] transition-colors p-1.5 rounded-lg hover:bg-purple-50">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            
                            <!-- Emoji Picker -->
                            <div id="emoji-picker-container" class="hidden absolute top-full left-0 mt-2 z-50 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] rounded-2xl overflow-hidden border border-gray-100">
                                <emoji-picker class="light" style="width: 320px; height: 350px; --background: #ffffff; --border-color: #f3f4f6; --input-border-color: #e5e7eb;"></emoji-picker>
                            </div>
                        </div>
                        <button type="submit" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-7 py-2.5 rounded-full font-bold text-[13px] shadow-md shadow-[#A881C2]/20 transition-all active:scale-95 tracking-wide">Posting</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="space-y-6">
    @forelse($threads as $thread)
        <div class="bg-white rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 relative group transition-all hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.06)]">
            @php
                $role = $thread->user->role ?? 'user';
                $isAnon = $role === 'user';
                $authorName = $isAnon ? 'User Anonim' : ($thread->user->nama_asli ?? 'User');
                
                $badgeClass = '';
                $badgeText = '';
                if ($role === 'admin') {
                    $badgeClass = 'bg-amber-100 text-amber-700';
                    $badgeText = 'Admin';
                } elseif ($role === 'konselor') {
                    $badgeClass = 'bg-blue-100 text-blue-700';
                    $badgeText = 'Dokter';
                } else {
                    $badgeClass = 'bg-gray-100 text-gray-500';
                    $badgeText = 'Anonim';
                }
            @endphp

            <div class="flex gap-4 md:gap-5">
                <div class="flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? 'F3F4F6' : 'E8DEFA' }}&color={{ $isAnon ? '9CA3AF' : '6B3FA0' }}&size=48&bold=true" 
                         alt="Avatar" class="w-12 h-12 rounded-full object-cover border border-gray-100">
                </div>
                
<<<<<<< HEAD
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-gray-900 text-[15px]">{{ $authorName }}</span>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-widest {{ $badgeClass }}">{{ $badgeText }}</span>
                            <span class="text-gray-400 text-[12px] font-medium ml-1">{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 text-[15px] leading-relaxed mb-5 whitespace-pre-wrap">{{ $thread->content }}</p>
                    
                    <div class="flex items-center gap-6">
                        <a href="{{ route('forum.show', $thread->id) }}" class="flex items-center gap-2 text-gray-400 hover:text-[#A881C2] transition-colors text-sm font-semibold group/btn">
                            <div class="p-1.5 rounded-lg group-hover/btn:bg-purple-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <span>{{ $thread->replies_count }}</span>
                        </a>
                        
                        <button type="button" onclick="handleLike(this, '{{ route('forum.like', $thread->id) }}')" class="flex items-center gap-2 transition-colors text-sm font-semibold group/btn {{ $thread->isLikedBy(Auth::id() ?? 1) ? 'text-red-500 is-liked' : 'text-gray-400 hover:text-red-500' }}">
                            <div class="p-1.5 rounded-lg group-hover/btn:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 like-icon" viewBox="0 0 24 24" fill="{{ $thread->isLikedBy(Auth::id() ?? 1) ? 'currentColor' : 'none' }}" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <span class="like-count">{{ $thread->likes_count }}</span>
                        </button>

                        <button type="button" onclick="handleSave(this, '{{ route('forum.save', $thread->id) }}')" class="flex items-center gap-2 transition-colors text-sm font-semibold group/btn {{ $thread->isSavedBy(Auth::id() ?? 1) ? 'text-[#A881C2] is-saved' : 'text-gray-400 hover:text-[#A881C2]' }}">
                            <div class="p-1.5 rounded-lg group-hover/btn:bg-purple-50 transition-colors">
                                <svg class="w-5 h-5 save-icon" viewBox="0 0 24 24" fill="{{ $thread->isSavedBy(Auth::id() ?? 1) ? 'currentColor' : 'none' }}" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            </div>
                            <span class="save-count">{{ $thread->saves_count }}</span>
                        </button>
                    </div>
                </div>

                <div class="absolute top-6 right-6">
                    <button onclick="document.getElementById('dropdown-{{ $thread->id }}').classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                    </button>
                    
                    <!-- Dropdown Content -->
                    <div id="dropdown-{{ $thread->id }}" class="hidden absolute right-0 top-full mt-1 w-40 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-10">
                        @if($thread->user_id === (Auth::id() ?? 1))
                            <form action="{{ route('forum.destroy', $thread->id) }}" method="POST" class="m-0" onsubmit="return confirm('Hapus post ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 font-semibold transition-colors">Hapus Post</button>
                            </form>
                        @else
                            <button onclick="document.getElementById('report-post-{{ $thread->id }}').classList.remove('hidden'); document.getElementById('dropdown-{{ $thread->id }}').classList.add('hidden');" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 font-semibold transition-colors">Laporkan</button>
                        @endif
                    </div>

                    <!-- Report Form -->
                    <form id="report-post-{{ $thread->id }}" action="{{ route('forum.report', $thread->id) }}" method="POST" class="hidden absolute right-0 top-full mt-1 w-64 bg-white border border-red-100 rounded-xl shadow-[0_10px_40px_-10px_rgba(239,68,68,0.2)] p-4 z-20">
                        @csrf
                        <div class="text-[13px] font-black uppercase tracking-wider text-red-500 mb-3">Laporkan Postingan</div>
                        <input type="text" name="reason" placeholder="Contoh: Spam, Mengganggu..." class="w-full px-3 py-2 border border-gray-200 rounded-lg mb-3 text-sm focus:outline-none focus:border-red-300 focus:ring-2 focus:ring-red-300/20 font-medium" required>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('report-post-{{ $thread->id }}').classList.add('hidden')" class="px-3 py-1.5 text-[13px] font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">Batal</button>
                            <button type="submit" class="px-4 py-1.5 text-[13px] font-bold bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all shadow-sm">Kirim</button>
                        </div>
                    </form>
                </div>
=======
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
>>>>>>> c4f0ce3ee1d03aa624144385bc96873f8fa0a5ba
            </div>
        </div>
    @empty
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-12 flex flex-col items-center justify-center min-h-[400px]">
            <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-[#A881C2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
            </div>
            <h4 class="text-gray-900 font-bold text-xl mb-2">Belum Ada Diskusi</h4>
            <p class="text-gray-500 text-[15px] text-center max-w-xs leading-relaxed">Jadilah yang pertama untuk memulai percakapan di forum ini!</p>
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
            if (emojiPickerContainer.classList.contains('hidden')) {
                emojiPickerContainer.classList.remove('hidden');
            } else {
                emojiPickerContainer.classList.add('hidden');
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
                emojiPickerContainer.classList.add('hidden');
            }
        });
    });
</script>
@endsection

@push('scripts')
<script>
function handleLike(btn, url) {
    const isLiked = btn.classList.contains('is-liked');
    const countSpan = btn.querySelector('.like-count');
    const icon = btn.querySelector('.like-icon');
    let count = parseInt(countSpan.textContent);
    
    // Optimistic UI update
    if (isLiked) {
        btn.classList.remove('is-liked', 'text-red-500');
        btn.classList.add('text-gray-400');
        icon.setAttribute('fill', 'none');
        countSpan.textContent = count - 1;
    } else {
        btn.classList.add('is-liked', 'text-red-500');
        btn.classList.remove('text-gray-400');
        icon.setAttribute('fill', 'currentColor');
        countSpan.textContent = count + 1;
    }

    // Actual request
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).catch(error => {
        console.error('Error:', error);
        // Revert on error (optional)
    });
}

function handleSave(btn, url) {
    const isSaved = btn.classList.contains('is-saved');
    const countSpan = btn.querySelector('.save-count');
    const icon = btn.querySelector('.save-icon');
    let count = parseInt(countSpan.textContent);
    
    // Optimistic UI update
    if (isSaved) {
        btn.classList.remove('is-saved', 'text-[#A881C2]');
        btn.classList.add('text-gray-400');
        icon.setAttribute('fill', 'none');
        countSpan.textContent = count - 1;
    } else {
        btn.classList.add('is-saved', 'text-[#A881C2]');
        btn.classList.remove('text-gray-400');
        icon.setAttribute('fill', 'currentColor');
        countSpan.textContent = count + 1;
    }

    // Actual request
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    }).catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endpush
