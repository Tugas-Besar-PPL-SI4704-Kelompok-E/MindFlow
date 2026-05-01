@extends('layouts.dashboard')

@section('title', 'Refleksi Diri - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 860px;
        margin: 0 auto;
        padding-bottom: 80px;
        animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .top-bar {
        margin-bottom: 32px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        color: #6B7280;
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        padding: 10px 20px;
        border-radius: 100px;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .btn-back:hover {
        background: #F9FAFB;
        color: #111827;
        border-color: #D1D5DB;
    }
    .btn-back svg {
        margin-right: 8px;
    }

    .form-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 32px;
        padding: 60px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
    }

    .header-context {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .icon-context {
        width: 72px;
        height: 72px;
        background: #F3E8FF;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7E22CE;
    }
    .icon-context svg {
        width: 36px; height: 36px;
    }
    
    .title-context h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #111827;
        letter-spacing: -0.5px;
    }
    .title-context p {
        color: #6B7280;
        font-size: 16px;
    }

    .question-prompt {
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-left: 6px solid #A855F7;
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 40px;
    }
    .question-prompt h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 12px;
        line-height: 1.6;
        color: #111827;
    }
    .question-prompt p {
        color: #6B7280;
        font-size: 16px;
        line-height: 1.6;
    }

    .textarea-wrapper {
        margin-bottom: 40px;
    }
    
    .form-textarea {
        width: 100%;
        min-height: 240px;
        padding: 24px;
        border: 2px solid #E5E7EB;
        border-radius: 20px;
        font-size: 16px;
        color: #111827;
        resize: vertical;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
        background: #FFFFFF;
        line-height: 1.7;
    }
    .form-textarea:focus {
        outline: none;
        border-color: #A855F7;
        box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.1);
    }
    .form-textarea::placeholder {
        color: #9CA3AF;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
    }
    
    .btn-submit {
        background: #111827;
        color: #FFFFFF;
        border: none;
        padding: 18px 48px;
        border-radius: 100px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        opacity: 0.3;
        pointer-events: none;
    }
    .btn-submit.ready {
        opacity: 1;
        pointer-events: auto;
        box-shadow: 0 10px 15px -3px rgba(17, 24, 39, 0.25);
    }
    .btn-submit.ready:hover {
        transform: translateY(-3px);
        background: #1F2937;
        box-shadow: 0 15px 25px -5px rgba(17, 24, 39, 0.35);
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="top-bar">
        <a href="{{ route('mood-tracker.singkat') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali
        </a>
    </div>

    <div class="form-card">
        <div class="header-context">
            <div class="icon-context">
                <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
            </div>
            <div class="title-context">
                <h2>Ruang Cerita (PCL-5)</h2>
                <p>Bagikan beban pikiranmu secara aman dan konfidensial.</p>
            </div>
        </div>

        <form action="{{ route('mood-tracker.open-question.store') }}" method="POST" id="openQuestionForm">
            @csrf
            @if(isset($checkInstanId))
                <input type="hidden" name="check_instan_id" value="{{ $checkInstanId }}">
            @endif
            
            <div class="question-prompt">
                <h3>Dalam satu bulan terakhir, seberapa sering pikiran atau kenangan tentang peristiwa masa lalu yang menegangkan/menyakitkan tiba-tiba muncul dan mengganggumu?</h3>
                <p>Luangkan waktumu. Ceritakan apa yang kamu rasakan, apa yang memicu hal tersebut, dan bagaimana hal itu memengaruhi aktivitas sehari-harimu belakangan ini.</p>
            </div>

            <div class="textarea-wrapper">
                <textarea 
                    name="open_answer" 
                    id="openAnswer" 
                    class="form-textarea" 
                    placeholder="Tuliskan apa yang sedang kamu rasakan di sini... (Ketikanmu dijamin kerahasiaannya)"
                    required
                ></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit" id="submitBtn">Simpan Catatan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const textarea = document.getElementById('openAnswer');
    const submitBtn = document.getElementById('submitBtn');

    textarea.addEventListener('input', function() {
        if (this.value.trim().length > 5) {
            submitBtn.classList.add('ready');
            submitBtn.removeAttribute('disabled');
        } else {
            submitBtn.classList.remove('ready');
            submitBtn.setAttribute('disabled', 'true');
        }
    });
</script>
@endsection

