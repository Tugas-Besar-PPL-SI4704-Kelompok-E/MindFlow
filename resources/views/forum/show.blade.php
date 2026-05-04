@extends('layouts.app')

@section('content')

    <div class="mb-10">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full border border-gray-200 bg-white hover:bg-gray-50 transition-all text-gray-600 hover:text-gray-900 group shadow-sm">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-semibold">Kembali</span>
        </a>
    </div>

<div class="bg-white rounded-[32px] p-6 md:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100">
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
                <div class="text-gray-400 text-[13px] font-medium">{{ $thread->created_at->format('h:i A · M d, Y') }}</div>
            </div>
        </div>

        <div class="relative">
            <button onclick="document.getElementById('dropdown-show-{{ $thread->id }}').classList.toggle('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-full hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
            </button>
            
            <!-- Dropdown Content -->
            <div id="dropdown-show-{{ $thread->id }}" class="hidden absolute right-0 top-full mt-1 w-40 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-10">
                @if($thread->user_id === (Auth::id() ?? 1))
                    <form action="{{ route('forum.destroy', $thread->id) }}" method="POST" class="m-0" onsubmit="return confirm('Hapus post ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 font-semibold transition-colors">Hapus Post</button>
                    </form>
                @else
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

@endsection
