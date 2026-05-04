@extends('layouts.public')

@section('title', 'Daftar Sebagai Konselor - MindFlow')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #f8f6ff 0%, #f0ebff 50%, #e8e0ff 100%);
        min-height: 100vh;
    }

    /* ===== NAVBAR ===== */
    .rk-navbar {
        position: fixed; top: 0; left: 0; right: 0; z-index: 100;
        background: rgba(255,255,255,0.85); backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0,0,0,0.04);
        padding: 0.75rem 2rem;
    }
    .rk-navbar-inner {
        max-width: 1100px; margin: 0 auto;
        display: flex; align-items: center; justify-content: space-between;
    }
    .rk-logo {
        font-size: 1.35rem; font-weight: 800; color: var(--primary-700);
        display: flex; align-items: center; gap: 0.5rem;
    }
    .rk-logo-icon {
        width: 34px; height: 34px; border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1rem;
    }
    .rk-nav-back {
        font-size: 0.85rem; font-weight: 600; color: var(--gray-500);
        display: flex; align-items: center; gap: 0.4rem; transition: color 0.2s;
    }
    .rk-nav-back:hover { color: var(--primary-600); }

    /* ===== MAIN ===== */
    .rk-main {
        max-width: 720px; margin: 0 auto;
        padding: 7rem 1.5rem 4rem;
    }

    /* ===== HEADER ===== */
    .rk-header {
        text-align: center; margin-bottom: 2.5rem;
    }
    .rk-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.35rem 1rem; border-radius: 50px;
        background: var(--primary-100); color: var(--primary-700);
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.05em; margin-bottom: 1rem;
    }
    .rk-header h1 {
        font-size: clamp(1.6rem, 4vw, 2.2rem); font-weight: 800;
        color: var(--gray-900); letter-spacing: -0.02em; margin-bottom: 0.75rem;
    }
    .rk-header p {
        font-size: 0.95rem; color: var(--gray-500); line-height: 1.7;
        max-width: 520px; margin: 0 auto;
    }

    /* ===== CARD ===== */
    .rk-card {
        background: white; border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 24px rgba(0,0,0,0.03), 0 1px 3px rgba(0,0,0,0.02);
        padding: 2.5rem;
    }

    /* ===== SECTION DIVIDERS ===== */
    .rk-section {
        margin-bottom: 2.5rem;
    }
    .rk-section:last-of-type { margin-bottom: 0; }
    .rk-section-header {
        display: flex; align-items: center; gap: 0.75rem;
        margin-bottom: 1.5rem; padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-100);
    }
    .rk-section-icon {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .rk-section-icon.blue { background: #dbeafe; color: #2563eb; }
    .rk-section-icon.green { background: #d1fae5; color: #059669; }
    .rk-section-icon.orange { background: #ffedd5; color: #ea580c; }
    .rk-section-title {
        font-size: 1rem; font-weight: 700; color: var(--gray-900);
    }
    .rk-section-subtitle {
        font-size: 0.8rem; color: var(--gray-400); font-weight: 500; margin-top: 2px;
    }

    /* ===== FORM FIELDS ===== */
    .rk-field { margin-bottom: 1.25rem; }
    .rk-field:last-child { margin-bottom: 0; }
    .rk-label {
        display: block; font-size: 0.85rem; font-weight: 700;
        color: var(--gray-700); margin-bottom: 0.4rem;
    }
    .rk-required {
        color: #ef4444; margin-left: 2px;
    }
    .rk-hint {
        font-size: 0.75rem; color: var(--gray-400); font-weight: 500;
        margin-top: 0.35rem; display: flex; align-items: center; gap: 0.35rem;
    }
    .rk-input, .rk-select {
        width: 100%; padding: 0.7rem 1rem;
        border: 1.5px solid var(--gray-200); border-radius: 12px;
        font-size: 0.9rem; font-family: 'Inter', sans-serif;
        color: var(--gray-800); background: var(--gray-50);
        transition: all 0.2s; outline: none;
    }
    .rk-input:focus, .rk-select:focus {
        border-color: var(--primary-400);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        background: white;
    }
    .rk-input::placeholder { color: var(--gray-400); }
    .rk-input.error, .rk-select.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
    }
    .rk-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 600px) { .rk-grid { grid-template-columns: 1fr; } }

    /* ===== FILE UPLOAD ===== */
    .rk-file-zone {
        border: 2px dashed var(--gray-200); border-radius: 14px;
        padding: 1.5rem; text-align: center;
        transition: all 0.2s; cursor: pointer; position: relative;
        background: var(--gray-50);
    }
    .rk-file-zone:hover {
        border-color: var(--primary-300); background: var(--primary-50);
    }
    .rk-file-zone.dragover {
        border-color: var(--primary-500); background: var(--primary-50);
        box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
    }
    .rk-file-zone input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer;
    }
    .rk-file-icon {
        font-size: 1.8rem; margin-bottom: 0.5rem; color: var(--gray-300);
    }
    .rk-file-text {
        font-size: 0.85rem; font-weight: 600; color: var(--gray-500);
    }
    .rk-file-text span { color: var(--primary-600); }
    .rk-file-meta {
        font-size: 0.72rem; color: var(--gray-400); margin-top: 0.25rem; font-weight: 500;
    }
    .rk-file-name {
        display: none; font-size: 0.8rem; font-weight: 600;
        color: var(--primary-700); margin-top: 0.5rem;
        background: var(--primary-50); padding: 0.3rem 0.75rem;
        border-radius: 8px; display: inline-flex; align-items: center; gap: 0.4rem;
    }

    /* ===== ERRORS ===== */
    .rk-errors {
        background: #fef2f2; border: 1px solid #fecaca; border-radius: 14px;
        padding: 1rem 1.25rem; margin-bottom: 2rem;
    }
    .rk-errors ul {
        list-style: none; padding: 0; margin: 0;
    }
    .rk-errors li {
        font-size: 0.82rem; color: #dc2626; font-weight: 500;
        padding: 0.2rem 0; display: flex; align-items: center; gap: 0.4rem;
    }
    .rk-errors li::before { content: '⚠'; font-size: 0.75rem; }

    /* ===== GLOBAL ALERT ===== */
    .rk-alert {
        background: #fef2f2; border: 1px solid #fecaca; border-radius: 14px;
        padding: 1rem 1.25rem; margin-bottom: 2rem; text-align: center;
        font-size: 0.85rem; color: #dc2626; font-weight: 600;
    }

    /* ===== SUBMIT ===== */
    .rk-actions {
        margin-top: 2.5rem; padding-top: 2rem;
        border-top: 1px solid var(--gray-100);
        display: flex; align-items: center; justify-content: space-between;
    }
    .rk-submit {
        padding: 0.85rem 2.5rem; border-radius: 14px;
        font-size: 0.95rem; font-weight: 700;
        color: white; background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        border: none; cursor: pointer; transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(79,70,229,0.25);
        font-family: 'Inter', sans-serif;
        display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .rk-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79,70,229,0.35);
    }
    .rk-submit:active { transform: translateY(0); }
    .rk-back-link {
        font-size: 0.85rem; font-weight: 600; color: var(--gray-500);
        transition: color 0.2s;
    }
    .rk-back-link:hover { color: var(--primary-600); }

    /* ===== FOOTER NOTE ===== */
    .rk-footer-note {
        text-align: center; margin-top: 2rem;
        font-size: 0.8rem; color: var(--gray-400); line-height: 1.6;
    }
    .rk-footer-note a { color: var(--primary-600); font-weight: 600; }

    /* ===== PASSWORD TOGGLE ===== */
    .rk-password-wrap {
        position: relative;
    }
    .rk-password-toggle {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; color: var(--gray-400);
        padding: 4px; font-size: 1rem;
    }
    .rk-password-toggle:hover { color: var(--gray-600); }
</style>
@endsection

@section('body')
    <!-- NAVBAR -->
    <nav class="rk-navbar">
        <div class="rk-navbar-inner">
            <a href="{{ route('home') }}" class="rk-logo">
                <div class="rk-logo-icon">🧠</div>
                MindFlow
            </a>
            <a href="{{ route('home') }}" class="rk-nav-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- MAIN -->
    <div class="rk-main">
        <!-- HEADER -->
        <div class="rk-header">
            <div class="rk-badge">🩺 Rekrutmen Konselor</div>
            <h1>Bergabung Sebagai Konselor Profesional</h1>
            <p>Lengkapi data di bawah ini untuk mengajukan diri sebagai konselor di MindFlow. Tim kami akan memverifikasi dokumen Anda.</p>
        </div>

        <!-- FORM CARD -->
        <div class="rk-card">
            @if (session('error'))
                <div class="rk-alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="rk-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rekrutmen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- SECTION 1: Data Akun & Kontak -->
                <div class="rk-section">
                    <div class="rk-section-header">
                        <div class="rk-section-icon blue">👤</div>
                        <div>
                            <div class="rk-section-title">Data Akun & Kontak</div>
                            <div class="rk-section-subtitle">Untuk login dan komunikasi</div>
                        </div>
                    </div>

                    <div class="rk-field">
                        <label class="rk-label">Nama Lengkap (Sesuai Ijazah + Gelar) <span class="rk-required">*</span></label>
                        <input type="text" name="nama_lengkap" class="rk-input @error('nama_lengkap') error @enderror" placeholder="Contoh: Dr. Aisyah Putri, M.Psi" value="{{ old('nama_lengkap') }}" required>
                    </div>

                    <div class="rk-grid">
                        <div class="rk-field">
                            <label class="rk-label">Email <span class="rk-required">*</span></label>
                            <input type="email" name="email" class="rk-input @error('email') error @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="rk-field">
                            <label class="rk-label">Nomor WhatsApp <span class="rk-required">*</span></label>
                            <input type="text" name="nomor_whatsapp" class="rk-input @error('nomor_whatsapp') error @enderror" placeholder="08xxxxxxxxxx" value="{{ old('nomor_whatsapp') }}" required>
                        </div>
                    </div>

                    <div class="rk-grid">
                        <div class="rk-field">
                            <label class="rk-label">Password <span class="rk-required">*</span></label>
                            <div class="rk-password-wrap">
                                <input type="password" name="password" id="password" class="rk-input @error('password') error @enderror" placeholder="Minimal 8 karakter" required>
                                <button type="button" class="rk-password-toggle" onclick="togglePassword('password', this)">👁</button>
                            </div>
                        </div>
                        <div class="rk-field">
                            <label class="rk-label">Konfirmasi Password <span class="rk-required">*</span></label>
                            <div class="rk-password-wrap">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="rk-input" placeholder="Ulangi password" required>
                                <button type="button" class="rk-password-toggle" onclick="togglePassword('password_confirmation', this)">👁</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Kredensial Profesi -->
                <div class="rk-section">
                    <div class="rk-section-header">
                        <div class="rk-section-icon green">📜</div>
                        <div>
                            <div class="rk-section-title">Kredensial Profesi</div>
                            <div class="rk-section-subtitle">Bukti kepakaran dan izin praktik Anda</div>
                        </div>
                    </div>

                    <div class="rk-grid">
                        <div class="rk-field">
                            <label class="rk-label">Nomor SIPP / SIPK <span class="rk-required">*</span></label>
                            <input type="text" name="no_sipp" class="rk-input @error('no_sipp') error @enderror" placeholder="Masukkan nomor SIPP Anda" value="{{ old('no_sipp') }}" required>
                            <div class="rk-hint">📌 Nomor Surat Izin Praktik Psikolog/Konselor resmi</div>
                        </div>
                        <div class="rk-field">
                            <label class="rk-label">Spesialisasi <span class="rk-required">*</span></label>
                            <select name="spesialisasi" class="rk-select @error('spesialisasi') error @enderror" required>
                                <option value="" disabled {{ old('spesialisasi') ? '' : 'selected' }}>Pilih spesialisasi...</option>
                                <option value="Klinis & Depresi" {{ old('spesialisasi') == 'Klinis & Depresi' ? 'selected' : '' }}>Klinis & Depresi</option>
                                <option value="Konseling Remaja" {{ old('spesialisasi') == 'Konseling Remaja' ? 'selected' : '' }}>Konseling Remaja</option>
                                <option value="Konseling Keluarga" {{ old('spesialisasi') == 'Konseling Keluarga' ? 'selected' : '' }}>Konseling Keluarga</option>
                                <option value="Trauma & PTSD" {{ old('spesialisasi') == 'Trauma & PTSD' ? 'selected' : '' }}>Trauma & PTSD</option>
                                <option value="Kecemasan & Stres" {{ old('spesialisasi') == 'Kecemasan & Stres' ? 'selected' : '' }}>Kecemasan & Stres</option>
                                <option value="Konseling Karir" {{ old('spesialisasi') == 'Konseling Karir' ? 'selected' : '' }}>Konseling Karir</option>
                                <option value="Adiksi & Ketergantungan" {{ old('spesialisasi') == 'Adiksi & Ketergantungan' ? 'selected' : '' }}>Adiksi & Ketergantungan</option>
                                <option value="Psikologi Pendidikan" {{ old('spesialisasi') == 'Psikologi Pendidikan' ? 'selected' : '' }}>Psikologi Pendidikan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Upload Dokumen -->
                <div class="rk-section">
                    <div class="rk-section-header">
                        <div class="rk-section-icon orange">📂</div>
                        <div>
                            <div class="rk-section-title">Upload Dokumen</div>
                            <div class="rk-section-subtitle">Bukti fisik untuk proses verifikasi</div>
                        </div>
                    </div>

                    <div class="rk-field">
                        <label class="rk-label">Scan KTP <span class="rk-required">*</span></label>
                        <div class="rk-file-zone" id="zone-ktp">
                            <input type="file" name="berkas_ktp" accept=".jpg,.jpeg,.png,.pdf" onchange="showFileName(this, 'fname-ktp')" required>
                            <div class="rk-file-icon">🪪</div>
                            <div class="rk-file-text">Klik atau seret file ke sini</div>
                            <div class="rk-file-meta">Format: JPG, PNG, PDF — Maks. 2MB</div>
                            <div class="rk-file-name" id="fname-ktp"></div>
                        </div>
                    </div>

                    <div class="rk-grid">
                        <div class="rk-field">
                            <label class="rk-label">File SIPP / Lisensi Aktif <span class="rk-required">*</span></label>
                            <div class="rk-file-zone" id="zone-sipp">
                                <input type="file" name="berkas_sipp" accept=".pdf" onchange="showFileName(this, 'fname-sipp')" required>
                                <div class="rk-file-icon">📄</div>
                                <div class="rk-file-text">Unggah file <span>PDF</span></div>
                                <div class="rk-file-meta">Format: PDF — Maks. 2MB</div>
                                <div class="rk-file-name" id="fname-sipp"></div>
                            </div>
                        </div>
                        <div class="rk-field">
                            <label class="rk-label">CV (Curriculum Vitae) <span class="rk-required">*</span></label>
                            <div class="rk-file-zone" id="zone-cv">
                                <input type="file" name="berkas_cv" accept=".pdf" onchange="showFileName(this, 'fname-cv')" required>
                                <div class="rk-file-icon">📋</div>
                                <div class="rk-file-text">Unggah file <span>PDF</span></div>
                                <div class="rk-file-meta">Format: PDF — Maks. 2MB</div>
                                <div class="rk-file-name" id="fname-cv"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="rk-actions">
                    <a href="{{ route('home') }}" class="rk-back-link">← Kembali</a>
                    <button type="submit" class="rk-submit">
                        Kirim Pendaftaran
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- FOOTER NOTE -->
        <div class="rk-footer-note">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a><br>
            Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> MindFlow.
        </div>
    </div>

    <script>
        // Show selected file name
        function showFileName(input, targetId) {
            const target = document.getElementById(targetId);
            if (input.files.length > 0) {
                target.style.display = 'inline-flex';
                target.textContent = '📎 ' + input.files[0].name;
            }
        }

        // Password visibility toggle
        function togglePassword(fieldId, btn) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                btn.textContent = '🙈';
            } else {
                field.type = 'password';
                btn.textContent = '👁';
            }
        }

        // Drag & drop visual feedback
        document.querySelectorAll('.rk-file-zone').forEach(zone => {
            zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('dragover'); });
            zone.addEventListener('dragleave', () => { zone.classList.remove('dragover'); });
            zone.addEventListener('drop', () => { zone.classList.remove('dragover'); });
        });
    </script>
@endsection
