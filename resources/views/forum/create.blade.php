@extends('layouts.dashboard')

@section('title', 'Buat Thread Baru - MindFlow Forum')

@section('styles')
<style>
    .form-card { background: #fff; border: 1px solid #E5E7EB; border-radius: 16px; overflow: hidden; }
    .form-header { background: #F3E8FF; border-bottom: 1px solid #E9D5FF; padding: 24px 32px; }
    .form-body { padding: 28px 32px; }
    .form-label { display: block; font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 15px; outline: none; transition: border 0.2s; font-family: inherit; }
    .form-input:focus { border-color: #7C3AED; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
    .form-textarea { width: 100%; padding: 14px 16px; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 15px; resize: none; outline: none; transition: border 0.2s; font-family: inherit; min-height: 180px; }
    .form-textarea:focus { border-color: #7C3AED; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
    .btn-submit { background: linear-gradient(135deg, #7C3AED, #5B21B6); color: white; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(91,33,182,0.3); }
</style>
@endsection

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <a href="{{ route('forum.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: #6B7280; margin-bottom: 20px; text-decoration: none;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Forum
    </a>

    <div class="form-card">
        <div class="form-header">
            <h2 style="font-size: 20px; font-weight: 800; color: #111827;">Buat Thread Baru</h2>
            <p style="font-size: 13px; color: #7C3AED; font-weight: 500; margin-top: 4px;">Bagikan cerita atau pertanyaanmu kepada komunitas.</p>
        </div>
        <div class="form-body">
            @if ($errors->any())
                <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;">
                    @foreach ($errors->all() as $error)
                        <p style="font-size: 13px; color: #991B1B;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('forum.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label class="form-label" for="judul_thread">Judul Thread</label>
                    <input type="text" name="judul_thread" id="judul_thread" class="form-input" placeholder="Contoh: Cara mengatasi kecemasan berlebih" value="{{ old('judul_thread') }}" required>
                </div>
                <div style="margin-bottom: 24px;">
                    <label class="form-label" for="konten">Isi Cerita</label>
                    <textarea name="konten" id="konten" class="form-textarea" placeholder="Ceritakan pengalamanmu atau ajukan pertanyaan..." required>{{ old('konten') }}</textarea>
                    <p style="font-size: 12px; color: #9CA3AF; margin-top: 6px;">Nama samaran kamu akan ditampilkan untuk menjaga privasi.</p>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <a href="{{ route('forum.index') }}" style="padding: 12px 24px; font-size: 14px; font-weight: 600; color: #6B7280; text-decoration: none;">Batal</a>
                    <button type="submit" class="btn-submit">Publikasikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
