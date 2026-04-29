@extends('layouts.dashboard')

@section('title', 'Pemeriksaan Singkat - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 840px;
        margin: 0 auto;
        padding-bottom: 60px;
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

    .survey-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 32px;
        padding: 70px 60px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        text-align: center;
    }

    .survey-title {
        font-size: 34px;
        font-weight: 700;
        color: #111827;
        letter-spacing: -1.2px;
        margin-bottom: 16px;
    }

    .survey-subtitle {
        font-size: 17px;
        color: #6B7280;
        margin-bottom: 64px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .emoji-row {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: nowrap;
        margin-bottom: 32px;
    }

    .emoji-item {
        position: relative;
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .emoji-btn {
        background: #F9FAFB;
        border: 2px solid transparent;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        filter: grayscale(100%) opacity(50%);
    }

    .emoji-btn:hover {
        transform: scale(1.15) translateY(-5px);
        filter: grayscale(0%) opacity(100%);
        background: #FFFFFF;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .emoji-btn.active {
        transform: scale(1.25) translateY(-8px);
        filter: grayscale(0%) opacity(100%);
        background: #FFFFFF;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #E5E7EB;
        z-index: 10;
    }

    .emoji-label {
        position: absolute;
        bottom: -28px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 14px;
        font-weight: 600;
        color: #9CA3AF;
        opacity: 0;
        transition: all 0.3s;
        pointer-events: none;
    }

    .emoji-item:hover .emoji-label,
    .emoji-btn.active + .emoji-label {
        opacity: 1;
        color: #4B5563;
        bottom: -32px;
    }

    .scale-guide {
        display: flex;
        justify-content: space-between;
        margin: 0 auto 60px auto;
        padding-top: 24px;
        border-top: 1px dashed #E5E7EB;
        color: #9CA3AF;
        font-size: 14px;
        font-weight: 500;
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

    /* Elegant Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(17, 24, 39, 0.4);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease;
    }
    .modal-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
    .modal-box {
        background: #FFFFFF;
        width: 100%;
        max-width: 440px;
        padding: 48px 40px;
        border-radius: 32px;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95) translateY(20px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .modal-overlay.show .modal-box {
        transform: scale(1) translateY(0);
    }
    .modal-icon {
        font-size: 56px;
        margin-bottom: 24px;
        display: inline-block;
        background: #FEF2F2;
        width: 96px; height: 96px;
        border-radius: 50%;
        line-height: 96px;
    }
    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }
    .modal-text {
        color: #6B7280;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 40px;
    }
    .modal-actions {
        display: flex;
        gap: 16px;
    }
    .btn-secondary {
        flex: 1;
        padding: 16px 20px;
        background: #F3F4F6;
        color: #374151;
        border-radius: 16px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #E5E7EB;
        color: #111827;
    }
    .btn-primary {
        flex: 1;
        padding: 16px 20px;
        background: #111827;
        color: #FFFFFF;
        border-radius: 16px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        background: #1F2937;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="top-bar">
        <a href="{{ route('mood-tracker.index') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali
        </a>
    </div>

    <div class="survey-card">
        <h2 class="survey-title">Bagaimana perasaanmu hari ini?</h2>
        <p class="survey-subtitle">Pilih tingkat emosi yang paling mewakili kondisimu saat ini (1 sangat buruk - 10 sangat baik).</p>

        <form action="{{ route('mood-tracker.singkat.store') }}" method="POST" id="moodForm">
            @csrf
            <input type="hidden" name="mood_score" id="moodScore" required>
            
            <div class="emoji-row">
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="1">😭</button>
                    <span class="emoji-label">1</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="2">😢</button>
                    <span class="emoji-label">2</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="3">😞</button>
                    <span class="emoji-label">3</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="4">😕</button>
                    <span class="emoji-label">4</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="5">😐</button>
                    <span class="emoji-label">5</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="6">🙂</button>
                    <span class="emoji-label">6</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="7">😊</button>
                    <span class="emoji-label">7</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="8">😄</button>
                    <span class="emoji-label">8</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="9">😁</button>
                    <span class="emoji-label">9</span>
                </div>
                <div class="emoji-item">
                    <button type="button" class="emoji-btn" data-value="10">🤩</button>
                    <span class="emoji-label">10</span>
                </div>
            </div>
            
            <div class="scale-guide">
                <span>Sangat Buruk</span>
                <span>Biasa Saja</span>
                <span>Sangat Baik</span>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">Simpan Aktivitas</button>
        </form>
    </div>

    <!-- Modal Pop-up -->
    <div class="modal-overlay" id="badMoodModal">
        <div class="modal-box">
            <div class="modal-icon">🫂</div>
            <h3 class="modal-title">Sepertinya harimu berat</h3>
            <p class="modal-text">Kami perhatikan suasana hatimu sedang kurang baik. Maukah kamu menceritakan lebih detail apa yang mengganggu pikiranmu agar kami bisa membantu?</p>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="btnSkipModal">Lewati</button>
                <a href="{{ route('mood-tracker.open-question') }}" class="btn-primary">Ya, Ceritakan</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const emojiBtns = document.querySelectorAll('.emoji-btn');
    const moodScoreInput = document.getElementById('moodScore');
    const submitBtn = document.getElementById('submitBtn');
    const moodForm = document.getElementById('moodForm');
    const modal = document.getElementById('badMoodModal');
    const btnSkipModal = document.getElementById('btnSkipModal');

    emojiBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            emojiBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            moodScoreInput.value = btn.getAttribute('data-value');
            submitBtn.classList.add('ready');
        });
    });

    moodForm.addEventListener('submit', function(e) {
        const score = parseInt(moodScoreInput.value);
        if (score <= 4) {
            e.preventDefault(); 
            modal.classList.add('show');
        }
    });

    btnSkipModal.addEventListener('click', function() {
        modal.classList.remove('show');
        moodForm.submit(); 
    });
</script>
@endsection
