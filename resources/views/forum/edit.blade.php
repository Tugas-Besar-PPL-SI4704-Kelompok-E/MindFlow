@extends('layouts.app')

@section('content')

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
