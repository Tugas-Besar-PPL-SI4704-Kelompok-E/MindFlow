@php
    $role = $reply->user->role ?? 'user';
    $isAnon = $role === 'user';
    $authorName = $isAnon ? 'User Anonim' : ($reply->user->nama_asli ?? 'User');
    
    $badgeClass = '';
    $badgeText = '';
    if ($role === 'admin') { $badgeClass = 'bg-amber-100 text-amber-700'; $badgeText = 'Admin'; } 
    elseif ($role === 'konselor') { $badgeClass = 'bg-blue-100 text-blue-700'; $badgeText = 'Dokter'; }
    else { $badgeClass = 'bg-gray-100 text-gray-500'; $badgeText = 'Anonim'; }
@endphp

<div class="relative {{ $depth === 0 ? 'bg-white rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 mt-6' : 'mt-4 ml-6 md:ml-10' }}">
    @if($depth > 0)
        <!-- Line connector for nested replies -->
        <div class="absolute left-[-20px] top-[-16px] bottom-0 w-[2px] bg-gray-100 rounded-full"></div>
        <div class="absolute left-[-20px] top-[24px] w-[16px] h-[2px] bg-gray-100 rounded-full"></div>
    @endif

    <div class="flex gap-4">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? 'F3F4F6' : 'E8DEFA' }}&color={{ $isAnon ? '9CA3AF' : '6B3FA0' }}&size=40&bold=true" 
             alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-gray-100 z-10 flex-shrink-0">
        
        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                <span class="font-bold text-gray-900 text-[14px]">{{ $authorName }}</span>
                <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-widest {{ $badgeClass }}">{{ $badgeText }}</span>
                <span class="text-gray-400 text-[12px] font-medium ml-1">{{ $reply->created_at->diffForHumans() }}</span>
            </div>
            
            <p class="text-gray-700 text-[14.5px] leading-relaxed whitespace-pre-wrap">{{ $reply->content }}</p>
            
            <div class="flex items-center gap-4 mt-3">
                <button onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.toggle('hidden'); document.getElementById('report-form-{{ $reply->id }}').classList.add('hidden');" class="flex items-center gap-1.5 text-gray-400 hover:text-[#A881C2] transition-colors text-xs font-bold px-2 py-1 -ml-2 rounded-lg hover:bg-purple-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Balas
                </button>
                <button onclick="document.getElementById('report-form-{{ $reply->id }}').classList.toggle('hidden'); document.getElementById('reply-form-{{ $reply->id }}').classList.add('hidden');" class="flex items-center gap-1.5 text-gray-400 hover:text-red-500 transition-colors text-xs font-bold px-2 py-1 rounded-lg hover:bg-red-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Laporkan
                </button>
            </div>

            <form id="reply-form-{{ $reply->id }}" action="{{ route('forum.reply', $reply->thread_id) }}" method="POST" class="hidden mt-3 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                @php
                    $currentUserRole = Auth::user()->role ?? 'user';
                    $isCurrentUserAnon = $currentUserRole === 'user';
                    $currentName = $isCurrentUserAnon ? 'User Anonim' : (Auth::user()->nama_asli ?? 'User');
                    $currentUserBadgeClass = $currentUserRole === 'admin' ? 'bg-amber-100 text-amber-700' : ($currentUserRole === 'konselor' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500');
                    $currentUserBadgeText = $currentUserRole === 'admin' ? 'Admin' : ($currentUserRole === 'konselor' ? 'Dokter' : 'Anonim');
                @endphp
                <div class="flex items-center gap-2 mb-2.5">
                    <span class="text-xs font-semibold text-gray-600">Membalas sebagai: <span class="text-gray-900">{{ $currentName }}</span></span>
                    <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest {{ $currentUserBadgeClass }}">{{ $currentUserBadgeText }}</span>
                </div>
                <div class="flex gap-2">
                    <input type="text" name="content" class="flex-1 bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#A881C2]/20 focus:border-[#A881C2] transition-all" placeholder="Balas ke {{ $authorName }}..." required>
                    <button type="submit" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-4 py-2 rounded-xl font-bold text-sm shadow-sm transition-all active:scale-95">Kirim</button>
                </div>
            </form>

            <!-- Report Form -->
            <form id="report-form-{{ $reply->id }}" action="{{ route('forum.reply.report', $reply->id) }}" method="POST" class="hidden mt-3 bg-red-50 p-4 rounded-2xl border border-red-100">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="reason" class="flex-1 bg-white border border-red-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-300/20 focus:border-red-400 transition-all placeholder-red-300" placeholder="Ketik alasan melapor..." required>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-bold text-sm shadow-sm transition-all active:scale-95">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
    
    @if($reply->children->isNotEmpty())
        <div class="mt-2">
            @foreach($reply->children as $childReply)
                @include('forum.partials.reply', ['reply' => $childReply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>
