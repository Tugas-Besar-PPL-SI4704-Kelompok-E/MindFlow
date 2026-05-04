@extends('layouts.app')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <div class="mb-10">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-4 group">
            <div class="w-11 h-11 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm group-hover:shadow group-hover:border-purple-200 transition-all text-gray-500 group-hover:text-[#A881C2]">
                <svg class="w-6 h-6 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <span class="text-[#4B5563] font-extrabold text-xl">Kembali</span>
        </a>
    </div>

<style>
    .form-card { background: #fff; border: 1px solid #E5E7EB; border-radius: 16px; overflow: hidden; }
    .form-header { background: #F3E8FF; border-bottom: 1px solid #E9D5FF; padding: 24px 32px; }
    .form-body { padding: 28px 32px; }
    .form-label { display: block; font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 15px; outline: none; transition: border 0.2s; font-family: inherit; }
    .form-input:focus { border-color: #A881C2; box-shadow: 0 0 0 3px rgba(168, 129, 194, 0.1); }
    .form-textarea { width: 100%; padding: 14px 16px; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 15px; resize: none; outline: none; transition: border 0.2s; font-family: inherit; min-height: 180px; }
    .form-textarea:focus { border-color: #A881C2; box-shadow: 0 0 0 3px rgba(168, 129, 194, 0.1); }
    .btn-submit { background: linear-gradient(135deg, #A881C2, #8A64A4); color: white; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(168, 129, 194, 0.3); }
</style>

    <div class="form-card">
        <div class="form-header">
            <h2 style="font-size: 20px; font-weight: 800; color: #111827;">Buat Thread Baru</h2>
            <p style="font-size: 13px; color: #A881C2; font-weight: 500; margin-top: 4px;">Bagikan cerita atau pertanyaanmu kepada komunitas.</p>
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
