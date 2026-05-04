@extends('layouts.dashboard')

@section('title', 'Pengaturan - MindFlow')

@section('styles')
    /* --- SETTINGS PAGE STYLES --- */
    .settings-container {
        width: 100%;
    }

    .settings-page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 6px;
    }

    .settings-page-subtitle {
        font-size: 15px;
        color: var(--text-muted);
        margin-bottom: 32px;
    }

    /* Tabs */
    .settings-tabs {
        display: flex;
        gap: 4px;
        background: #F1F1F3;
        border-radius: 14px;
        padding: 4px;
        margin-bottom: 32px;
    }

    .settings-tab {
        flex: 1;
        padding: 12px 20px;
        border: none;
        background: transparent;
        border-radius: 11px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.25s ease;
        text-align: center;
    }

    .settings-tab:hover {
        color: var(--text-dark);
    }

    .settings-tab.active {
        background: var(--bg-surface);
        color: var(--primary-purple);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .settings-tab-content {
        display: none;
    }

    .settings-tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Card */
    .settings-card {
        background: var(--bg-surface);
        border-radius: 20px;
        padding: 36px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--border-color);
    }

    /* Form elements */
    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: var(--text-dark);
        background: var(--bg-body);
        outline: none;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 3px rgba(155, 118, 214, 0.15);
        background: var(--bg-surface);
    }

    .form-error {
        font-size: 13px;
        color: #DC2626;
        margin-top: 6px;
    }

    .form-divider {
        border: none;
        border-top: 1px solid var(--border-color);
        margin: 32px 0;
    }

    .form-section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .form-section-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .btn-save {
        width: 100%;
        padding: 14px;
        background: var(--primary-purple);
        color: #FFF;
        border: none;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(155, 118, 214, 0.3);
    }

    .btn-save:hover {
        background: #8A63C8;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(155, 118, 214, 0.4);
    }

    .btn-save:active {
        transform: translateY(0);
    }

    /* Success Alert */
    .alert-success {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 12px;
        color: #166534;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
    }

    .alert-success svg {
        width: 20px;
        height: 20px;
        stroke: #16A34A;
        stroke-width: 2;
        fill: none;
        flex-shrink: 0;
    }

    /* --- FAQ STYLES --- */
    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .faq-item {
        background: var(--bg-body);
        border-radius: 14px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .faq-item:hover {
        border-color: rgba(155, 118, 214, 0.3);
    }

    .faq-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        cursor: pointer;
        list-style: none;
        user-select: none;
    }

    .faq-summary::-webkit-details-marker {
        display: none;
    }

    .faq-question {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        flex: 1;
        margin-right: 16px;
    }

    .faq-icon {
        width: 24px;
        height: 24px;
        stroke: var(--text-muted);
        stroke-width: 2;
        fill: none;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }

    .faq-item[open] .faq-icon {
        transform: rotate(45deg);
        stroke: var(--primary-purple);
    }

    .faq-item[open] {
        border-color: rgba(155, 118, 214, 0.3);
        background: var(--bg-surface);
    }

    .faq-answer {
        padding: 0 24px 20px;
        font-size: 14px;
        line-height: 1.7;
        color: var(--text-muted);
    }
@endsection

@section('content')
    <div class="settings-container">
        <h1 class="settings-page-title">Pengaturan</h1>
        <p class="settings-page-subtitle">Kelola profil akun dan lihat bantuan.</p>

        <!-- Tabs -->
        <div class="settings-tabs">
            <button class="settings-tab active" data-tab="profil" id="tab-profil" onclick="switchTab('profil')">
                Profil
            </button>
            <button class="settings-tab" data-tab="faq" id="tab-faq" onclick="switchTab('faq')">
                FAQ
            </button>
        </div>

        <!-- Tab: Profil -->
        <div class="settings-tab-content active" id="content-profil">
            @if(session('success'))
                <div class="alert-success">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="settings-card">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Asli -->
                    <div class="form-group">
                        <label for="nama_asli" class="form-label">Nama Asli</label>
                        <input type="text" name="nama_asli" id="nama_asli" value="{{ old('nama_asli', $user->nama_asli) }}" class="form-input" required>
                        @error('nama_asli')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Samaran -->
                    <div class="form-group">
                        <label for="nama_samaran" class="form-label">Nama Samaran (Pseudonym)</label>
                        <input type="text" name="nama_samaran" id="nama_samaran" value="{{ old('nama_samaran', $user->nama_samaran) }}" class="form-input" required>
                        @error('nama_samaran')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="form-divider">

                    <h2 class="form-section-title">Ubah Kata Sandi</h2>
                    <p class="form-section-subtitle">Kosongkan jika tidak ingin mengubah kata sandi.</p>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password" class="form-input">
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                    </div>

                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Tab: FAQ -->
        <div class="settings-tab-content" id="content-faq">
            <div class="settings-card">
                <h2 class="form-section-title" style="margin-bottom: 6px;">Frequently Asked Questions</h2>
                <p class="form-section-subtitle" style="margin-bottom: 28px;">Punya pertanyaan? Berikut jawaban dari pertanyaan yang sering ditanyakan.</p>

                <div class="faq-list">
                    <!-- FAQ 1 -->
                    <details class="faq-item">
                        <summary class="faq-summary">
                            <span class="faq-question">Apa itu MindFlow?</span>
                            <svg class="faq-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </summary>
                        <div class="faq-answer">
                            MindFlow adalah platform kesejahteraan mental yang dirancang untuk membantu Anda melacak suasana hati, berlatih mindfulness, dan terhubung dengan konselor profesional.
                        </div>
                    </details>

                    <!-- FAQ 2 -->
                    <details class="faq-item">
                        <summary class="faq-summary">
                            <span class="faq-question">Apakah data dan privasi saya aman?</span>
                            <svg class="faq-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </summary>
                        <div class="faq-answer">
                            Tentu saja. Privasi pengguna adalah prioritas utama kami. Kami menggunakan nama samaran (pseudonym) dan enkripsi standar industri untuk melindungi seluruh percakapan dan data pribadi Anda.
                        </div>
                    </details>

                    <!-- FAQ 3 -->
                    <details class="faq-item">
                        <summary class="faq-summary">
                            <span class="faq-question">Bagaimana cara mengubah profil dan nama samaran saya?</span>
                            <svg class="faq-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </summary>
                        <div class="faq-answer">
                            Anda dapat mengubahnya di tab <strong>Profil</strong> pada halaman Pengaturan ini. Di sana Anda dapat memperbarui Nama Asli, Nama Samaran, serta Kata Sandi Anda.
                        </div>
                    </details>

                    <!-- FAQ 4 -->
                    <details class="faq-item">
                        <summary class="faq-summary">
                            <span class="faq-question">Apakah konseling di MindFlow berbayar?</span>
                            <svg class="faq-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </summary>
                        <div class="faq-answer">
                            Kami menyediakan layanan dasar gratis (seperti Jurnal dan Tracker Suasana Hati). Namun untuk konseling secara profesional, kami menerapkan biaya konsultasi yang transparan sesuai dengan tarif masing-masing konselor.
                        </div>
                    </details>

                    <!-- FAQ 5 -->
                    <details class="faq-item">
                        <summary class="faq-summary">
                            <span class="faq-question">Bagaimana cara membuat janji konseling?</span>
                            <svg class="faq-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </summary>
                        <div class="faq-answer">
                            Kunjungi menu <strong>Konsultasi</strong> di sidebar, lalu klik tombol "Buat Janji". Pilih konselor yang tersedia, tentukan jadwal yang cocok, dan konfirmasi pemesanan Anda.
                        </div>
                    </details>

                    <!-- FAQ 6 -->
                    <details class="faq-item">
                        <summary class="faq-summary">
                            <span class="faq-question">Apa itu Mood Tracker dan bagaimana cara menggunakannya?</span>
                            <svg class="faq-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </summary>
                        <div class="faq-answer">
                            Mood Tracker adalah fitur untuk memantau kondisi emosional Anda sehari-hari. Tersedia pemeriksaan singkat (check-in harian) dan pemeriksaan mendalam menggunakan kuesioner DASS-21 untuk evaluasi lebih detail.
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function switchTab(tabName) {
        // Deactivate all tabs
        document.querySelectorAll('.settings-tab').forEach(function(tab) {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.settings-tab-content').forEach(function(content) {
            content.classList.remove('active');
        });

        // Activate selected tab
        document.getElementById('tab-' + tabName).classList.add('active');
        document.getElementById('content-' + tabName).classList.add('active');
    }

    // Handle URL hash for direct FAQ navigation
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#faq') {
            switchTab('faq');
        }
    });
</script>
@endsection
