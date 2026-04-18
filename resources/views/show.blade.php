@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('konseling.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card p-4">
                <h2>{{ $konselor->nama }}</h2>
                <h4 class="text-primary">{{ $konselor->spesialisasi }}</h4>
                <hr>
                <h5>Biografi:</h5>
                <p>{{ $konselor->biografi }}</p>
                <h5>Keahlian:</h5>
                <p>{{ $konselor->keahlian }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 border-primary">
                <h5>Booking Sesi (PBI 29)</h5>
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="konselor_id" value="{{ $konselor->id }}">
                    
                    <div class="mb-3">
                        <label>Pilih Jadwal:</label>
                        <input type="datetime-local" name="jadwal" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Konfirmasi Reservasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection