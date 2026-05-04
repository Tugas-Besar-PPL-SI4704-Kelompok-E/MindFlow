@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil - MindFlow')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #f8f6ff 0%, #f0ebff 50%, #e8e0ff 100%);
        min-height: 100vh; display: flex; align-items: center; justify-content: center;
    }
    .success-card {
        max-width: 520px; width: 100%; margin: 2rem;
        background: white; border-radius: 24px; padding: 3rem;
        text-align: center;
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.04);
    }
    .success-icon {
        width: 80px; height: 80px; border-radius: 50%;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem; font-size: 2.5rem;
        animation: popIn 0.5s ease both;
    }
    @keyframes popIn {
        from { transform: scale(0.5); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .success-card h1 {
        font-size: 1.5rem; font-weight: 800; color: var(--gray-900);
        margin-bottom: 0.75rem; letter-spacing: -0.02em;
    }
    .success-card p {
        font-size: 0.95rem; color: var(--gray-500); line-height: 1.7;
        margin-bottom: 2rem;
    }
    .success-steps {
        text-align: left; background: var(--gray-50); border-radius: 14px;
        padding: 1.25rem 1.5rem; margin-bottom: 2rem;
    }
    .success-steps h3 {
        font-size: 0.8rem; font-weight: 700; color: var(--gray-600);
        text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;
    }
    .success-steps ol {
        list-style: none; counter-reset: steps; padding: 0; margin: 0;
    }
    .success-steps li {
        counter-increment: steps; font-size: 0.85rem; color: var(--gray-600);
        padding: 0.4rem 0; display: flex; align-items: flex-start; gap: 0.75rem;
    }
    .success-steps li::before {
        content: counter(steps);
        min-width: 24px; height: 24px; border-radius: 50%;
        background: var(--primary-100); color: var(--primary-700);
        font-size: 0.75rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
    }
    .success-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 2rem; border-radius: 12px;
        font-size: 0.9rem; font-weight: 700;
        color: white; background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
        transition: all 0.3s; box-shadow: 0 4px 15px rgba(79,70,229,0.25);
    }
    .success-btn:hover {
        transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.35);
    }
</style>
@endsection

@section('body')
    <div class="success-card">
        <div class="success-icon">✅</div>
        <h1>Pendaftaran Berhasil Dikirim!</h1>
        <p>Terima kasih telah mendaftar sebagai konselor di MindFlow. Tim kami akan memverifikasi dokumen Anda dalam waktu 1-3 hari kerja.</p>

        <div class="success-steps">
            <h3>Langkah Selanjutnya</h3>
            <ol>
                <li>Tim Admin akan meninjau dokumen Anda (KTP, SIPP, CV).</li>
                <li>Anda akan menerima notifikasi melalui email setelah proses verifikasi selesai.</li>
                <li>Setelah di-approve, Anda bisa login dan mulai melengkapi profil (foto, biografi, tarif).</li>
            </ol>
        </div>

        <a href="{{ route('home') }}" class="success-btn">
            Kembali ke Beranda
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    </div>
@endsection
