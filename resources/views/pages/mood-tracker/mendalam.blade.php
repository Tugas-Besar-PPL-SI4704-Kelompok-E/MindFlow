@extends('layouts.dashboard', ['hideSidebar' => true])

@section('title', 'Pemeriksaan Mendalam (DASS-21) - MindFlow')

@section('styles')
<style>
    .page-wrapper {
        max-width: 900px;
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

    .header-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 32px;
        padding: 48px;
        margin-bottom: 40px;
        display: flex;
        align-items: flex-start;
        gap: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .icon-header {
        width: 80px;
        height: 80px;
        background: #F3E8FF;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .icon-header svg {
        stroke: #7E22CE;
        width: 40px; height: 40px;
    }
    
    .title-header h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: -1px;
        color: #111827;
    }
    .title-header p {
        color: #6B7280;
        font-size: 16px;
        line-height: 1.7;
    }

    .info-badge {
        display: inline-block;
        background: #ECFDF5;
        color: #059669;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
        letter-spacing: 0.5px;
    }

    /* Questions */
    .q-row {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 24px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .q-row:hover {
        border-color: #D1D5DB;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        transform: translateY(-2px);
    }
    
    .q-text {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 24px;
        line-height: 1.6;
    }
    
    .q-options-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    
    .q-radio-label {
        display: block;
        position: relative;
    }
    .q-radio-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .q-radio-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 20px 16px;
        background: #F9FAFB;
        border: 2px solid transparent;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 600;
        color: #6B7280;
        transition: all 0.2s;
        cursor: pointer;
        text-align: center;
    }
    
    .q-radio-label:hover .q-radio-btn {
        background: #F3F4F6;
        color: #374151;
        transform: translateY(-2px);
    }
    
    .q-radio-label input:checked ~ .q-radio-btn {
        background: #F3E8FF;
        border-color: #A855F7;
        color: #7E22CE;
        box-shadow: 0 4px 6px -1px rgba(168, 85, 247, 0.1);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 48px;
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
        box-shadow: 0 10px 15px -3px rgba(17, 24, 39, 0.25);
    }
    .btn-submit:hover {
        transform: translateY(-3px);
        background: #1F2937;
        box-shadow: 0 15px 25px -5px rgba(17, 24, 39, 0.35);
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

    <div class="header-card">
        <div class="icon-header">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <circle cx="12" cy="11" r="3"/>
            </svg>
        </div>
        <div class="title-header">
            <span class="info-badge">Standar DASS-21</span>
            <h2>Pemeriksaan Mendalam</h2>
            <p>Kuesioner klinis untuk menilai tingkat stres, kecemasan, dan depresi. Pilih jawaban yang paling sesuai dengan kondisimu selama <strong>satu minggu terakhir</strong>. Pastikan tidak ada jawaban yang terlewat.</p>
        </div>
    </div>

    @php
        $questions = [
            "Saya merasa bahwa saya menjadi marah karena hal-hal sepele.",
            "Saya merasa mulut saya sering kering.",
            "Saya sama sekali tidak dapat merasakan perasaan positif.",
            "Saya mengalami kesulitan bernapas (misal: sering terengah-engah padahal tidak melakukan aktivitas fisik).",
            "Saya merasa seolah-olah tidak kuat lagi untuk melakukan suatu kegiatan.",
            "Saya cenderung bereaksi berlebihan terhadap suatu situasi.",
            "Saya merasa gemetar (misalnya pada tangan).",
            "Saya merasa sulit untuk bersantai atau relaksasi.",
            "Saya merasa cemas berlebihan dalam situasi di mana saya bisa saja menjadi panik atau mempermalukan diri sendiri.",
            "Saya merasa tidak ada hal yang bisa diharapkan di masa depan.",
            "Saya menyadari bahwa saya mudah merasa gelisah.",
            "Saya merasa sulit untuk menjadi tenang setelah sesuatu mengganggu saya.",
            "Saya merasa sedih dan tertekan.",
            "Saya sulit untuk sabar saat mengalami penundaan (misalnya saat menunggu sesuatu).",
            "Saya merasa hampir panik.",
            "Saya tidak merasa antusias terhadap apapun.",
            "Saya merasa bahwa saya tidak berharga sebagai seorang manusia.",
            "Saya merasa bahwa saya sangat mudah tersinggung.",
            "Saya menyadari perubahan detak jantung saya padahal tidak habis melakukan aktivitas fisik berat.",
            "Saya merasa ketakutan tanpa alasan yang jelas.",
            "Saya merasa bahwa hidup ini tidak bermanfaat."
        ];
    @endphp

    <form action="{{ route('mood-tracker.mendalam.store') }}" method="POST" id="dass21Form">
        @csrf
        
        @foreach($questions as $index => $question)
            <div class="q-row">
                <p class="q-text"><strong>{{ $index + 1 }}.</strong> {{ $question }}</p>
                
                <input type="hidden" name="responses[{{ $index + 1 }}][question_id]" value="{{ $index + 1 }}">

                <div class="q-options-grid">
                    <label class="q-radio-label">
                        <input type="radio" name="responses[{{ $index + 1 }}][score]" value="0" required>
                        <div class="q-radio-btn">Tidak Pernah</div>
                    </label>
                    <label class="q-radio-label">
                        <input type="radio" name="responses[{{ $index + 1 }}][score]" value="1" required>
                        <div class="q-radio-btn">Kadang-kadang</div>
                    </label>
                    <label class="q-radio-label">
                        <input type="radio" name="responses[{{ $index + 1 }}][score]" value="2" required>
                        <div class="q-radio-btn">Sering</div>
                    </label>
                    <label class="q-radio-label">
                        <input type="radio" name="responses[{{ $index + 1 }}][score]" value="3" required>
                        <div class="q-radio-btn">Hampir Selalu</div>
                    </label>
                </div>
            </div>
        @endforeach

        <div class="form-actions">
            <button type="submit" class="btn-submit">Kirim Evaluasi</button>
        </div>
    </form>
</div>
@endsection
