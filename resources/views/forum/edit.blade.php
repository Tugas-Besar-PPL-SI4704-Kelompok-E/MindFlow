@extends('layouts.app')

@section('content')

    <div class="mb-10">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-4 group">
            <div class="w-11 h-11 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm group-hover:shadow group-hover:border-purple-200 transition-all text-gray-500 group-hover:text-[#A881C2]">
                <svg class="w-6 h-6 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <span class="text-[#4B5563] font-extrabold text-xl">Kembali</span>
        </a>
    </div>

<style>
    .edit-post {
        background: var(--card-bg);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border);
    }
    
    .edit-header {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border);
    }
    
    .edit-header h2 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
    }
</style>

<div class="edit-post">
    <div class="edit-header">
        <h2>Edit Post #{{ $thread->id }}</h2>
    </div>

    <form action="{{ route('forum.update', $thread->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <textarea name="content" class="form-control" rows="5" required>{{ old('content', $thread->content) }}</textarea>
            @error('content')
                <div style="color: var(--danger); font-size: 0.85rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>
        
                
        <div class="form-actions">
            <a href="{{ route('forum.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

@endsection
