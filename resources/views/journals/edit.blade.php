@extends('layouts.dashboard')

@section('title', 'Edit Jurnal - MindFlow')

@section('styles')
    .journal-form-container {
        max-width: 1000px;
        margin: 0 auto;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        min-height: 500px;
        overflow: hidden;
    }

    .journal-form-header {
        background: #F3E8FF;
        border-bottom: 1px solid #EDE9FE;
        padding: 20px 32px;
    }

    .journal-form-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .journal-form-header p {
        font-size: 13px;
        font-weight: 500;
        color: #6D28D9;
    }

    .journal-form-body {
        padding: 24px 32px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .journal-form-body label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .journal-textarea {
        width: 100%;
        flex-grow: 1;
        min-height: 200px;
        padding: 16px 20px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        color: #374151;
        resize: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .journal-textarea:focus {
        outline: none;
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 3px rgba(155, 118, 214, 0.15);
    }

    .journal-hint {
        font-size: 12px;
        color: #9CA3AF;
        font-weight: 500;
        margin-top: 8px;
    }

    .journal-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #F3F4F6;
    }

    .btn-cancel {
        padding: 10px 20px;
        color: #6B7280;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .btn-cancel:hover {
        color: #111827;
    }

    .btn-save {
        background: #5B21B6;
        color: #FFFFFF;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: background 0.2s;
    }

    .btn-save:hover {
        background: #4C1D95;
    }

    .btn-save:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(155, 118, 214, 0.3);
    }

    .validation-errors {
        background: #FEF2F2;
        color: #DC2626;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 14px;
    }

    .validation-errors ul {
        list-style: disc;
        padding-left: 20px;
    }
@endsection

@section('content')
    <div class="journal-form-container">
        <div class="journal-form-header">
            <h2>Edit Jurnal</h2>
            <p>Mengubah atau menambahkan detail pada refleksi Anda.</p>
        </div>

        <div class="journal-form-body">
            @if ($errors->any())
                <div class="validation-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('journals.update', $journal->journal_id) }}" method="POST" style="display: flex; flex-direction: column; flex-grow: 1;">
                @csrf
                @method('PUT')

                <div style="flex-grow: 1; display: flex; flex-direction: column;">
                    <label for="content">Refleksi Hari Ini</label>
                    <textarea
                        name="content"
                        id="content"
                        class="journal-textarea"
                        required
                    >{{ old('content', $journal->content) }}</textarea>
                    <p class="journal-hint">Anda pertama kali menulis ini pada {{ $journal->created_at->format('d M Y') }}.</p>
                </div>

                <div class="journal-form-actions">
                    <a href="{{ route('journals.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
