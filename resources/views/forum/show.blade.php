@extends('layouts.app')

@section('content')

<div class="pb-12">
    <div class="mb-10">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 transition-all text-gray-600 hover:text-gray-900 group shadow-sm">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-semibold">Kembali</span>
        </a>
    </div>

<div class="bg-white/80 backdrop-blur-xl rounded-[32px] p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white/50 mb-8">
    @php
        $role = $thread->user->role ?? 'user';
        $isAnon = $role === 'user';
        $authorName = $isAnon ? 'User Anonim' : ($thread->user->nama_asli ?? 'User');
        $initial = $isAnon ? '?' : strtoupper(substr($authorName, 0, 1));
        
        $badgeClass = '';
        $badgeText = '';
        if ($role === 'admin') { $badgeClass = 'bg-amber-100 text-amber-700'; $badgeText = 'Admin'; } 
        elseif ($role === 'konselor') { $badgeClass = 'bg-blue-100 text-blue-700'; $badgeText = 'Dokter'; }
        else { $badgeClass = 'bg-gray-100 text-gray-500'; $badgeText = 'Anonim'; }
    @endphp

    <div class="flex items-center justify-between mb-5 relative">
        <div class="flex items-center gap-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&background={{ $isAnon ? 'F3F4F6' : 'E8DEFA' }}&color={{ $isAnon ? '9CA3AF' : '6B3FA0' }}&size=48&bold=true" 
                 alt="Avatar" class="w-12 h-12 rounded-full object-cover border border-gray-100">
            <div>
                <div class="font-bold text-gray-900 text-[16px] mb-0.5">{{ $authorName }} <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-widest {{ $badgeClass }} ml-1">{{ $badgeText }}</span></div>
                <div class="text-gray-400 text-[13px] font-medium">
                    {{ $thread->created_at->format('h:i A · M d, Y') }}
                    @if($thread->created_at != $thread->updated_at)
                        <span class="italic text-[11px] ml-1">(Edited)</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="relative">
            <button onclick="document.getElementById('dropdown-show-{{ $thread->id }}').classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-full hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
            </button>
            
            <!-- Dropdown Content -->
            <div id="dropdown-show-{{ $thread->id }}" class="hidden absolute right-0 top-full mt-1 w-40 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-10">
                @if($thread->user_id === (Auth::id() ?? 1) && $thread->created_at->diffInMinutes(now()) <= 15)
                    <a href="{{ route('forum.edit', $thread->id) }}" class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 font-semibold transition-colors">Edit Post</a>
                @endif
                @if($thread->user_id === (Auth::id() ?? 1) || (Auth::user() && Auth::user()->role === 'admin'))
                    <button type="button" onclick="openDeleteModal('{{ route('forum.destroy', $thread->id) }}')" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 font-semibold transition-colors">Hapus Post</button>
                @endif
                @if(Auth::user()->role !== 'admin' && $thread->user_id !== (Auth::id() ?? 1))
                    <button onclick="document.getElementById('report-post-show-{{ $thread->id }}').classList.remove('hidden'); document.getElementById('dropdown-show-{{ $thread->id }}').classList.add('hidden');" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 font-semibold transition-colors">Laporkan</button>
                @endif
            </div>

            <!-- Report Form -->
            <form id="report-post-show-{{ $thread->id }}" action="{{ route('forum.report', $thread->id) }}" method="POST" class="hidden absolute right-0 top-full mt-1 w-64 bg-white border border-red-100 rounded-xl shadow-[0_10px_40px_-10px_rgba(239,68,68,0.2)] p-4 z-20">
                @csrf
                <div class="text-[13px] font-black uppercase tracking-wider text-red-500 mb-3">Laporkan Postingan</div>
                <input type="text" name="reason" placeholder="Contoh: Spam, Mengganggu..." class="w-full px-3 py-2 border border-gray-200 rounded-lg mb-3 text-sm focus:outline-none focus:border-red-300 focus:ring-2 focus:ring-red-300/20 font-medium" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('report-post-show-{{ $thread->id }}').classList.add('hidden')" class="px-3 py-1.5 text-[13px] font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">Batal</button>
                    <button type="submit" class="px-4 py-1.5 text-[13px] font-bold bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all shadow-sm">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-gray-800 text-[17px] leading-relaxed mb-6 whitespace-pre-wrap">{{ $thread->content }}</div>

    @php
        $currentUserRole = Auth::user()->role ?? 'user';
        $isCurrentUserAnon = $currentUserRole === 'user';
        $currentName = $isCurrentUserAnon ? 'User Anonim' : (Auth::user()->nama_asli ?? 'User');
        $currentUserBadgeClass = $currentUserRole === 'admin' ? 'bg-amber-100 text-amber-700' : ($currentUserRole === 'konselor' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500');
        $currentUserBadgeText = $currentUserRole === 'admin' ? 'Admin' : ($currentUserRole === 'konselor' ? 'Dokter' : 'Anonim');
    @endphp
    
    <div class="pt-6 border-t border-gray-100">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-sm font-semibold text-gray-600">Membalas sebagai: <span class="text-gray-900">{{ $currentName }}</span></span>
            <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-widest {{ $currentUserBadgeClass }}">{{ $currentUserBadgeText }}</span>
        </div>
        <form action="{{ route('forum.reply', $thread->id) }}" method="POST" class="flex gap-3">
            @csrf
            <input type="text" name="content" class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-[#A881C2]/10 focus:border-[#A881C2] focus:bg-white text-[14px] text-gray-700 font-medium transition-all placeholder-gray-400" placeholder="Tulis balasanmu di sini..." required>
            <button type="submit" class="bg-[#A881C2] hover:bg-[#8A64A4] text-white px-8 py-3.5 rounded-2xl font-bold text-[14px] shadow-md shadow-[#A881C2]/20 transition-all active:scale-95 tracking-wide">Balas</button>
        </form>
    </div>
</div>

<div class="replies-section">
    @foreach($replies as $reply)
        @include('forum.partials.reply', ['reply' => $reply, 'depth' => 0])
    @endforeach
</div>
</div>

<!-- Delete Confirm Modal -->
<div id="deleteConfirmModal" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[100] flex items-center justify-center">
    <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden transform transition-all scale-100">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Konfirmasi Hapus
            </h3>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus Post Ini?</h4>
            <p class="text-sm text-gray-500">Postingan ini akan dihapus dan tidak bisa dikembalikan lagi.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-center gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-200 bg-gray-100 rounded-xl transition-colors">Batal</button>
            <form id="deleteConfirmForm" method="POST" action="" class="m-0">
                @csrf @method('DELETE')
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-sm shadow-red-500/30">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(actionUrl) {
        document.getElementById('deleteConfirmForm').action = actionUrl;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
        document.getElementById('deleteConfirmForm').action = '';
    }
</script>
@endsection

@push('scripts')
<script>
    // Close dropdowns and report forms when clicking outside
    document.addEventListener('click', function(e) {
        // Find if click is on a dropdown button
        const isDropdownBtn = e.target.closest('button[onclick*="dropdown-"]');
        const isInsideDropdown = e.target.closest('[id^="dropdown-"]');
        const isInsideReport = e.target.closest('[id^="report-"]');
        
        if (!isDropdownBtn && !isInsideDropdown && !isInsideReport) {
            document.querySelectorAll('[id^="dropdown-"], [id^="report-"]').forEach(d => d.classList.add('hidden'));
        }
    });
</script>
@endpush
