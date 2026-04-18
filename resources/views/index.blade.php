@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Konselor MindFlow</h1>

    <form action="{{ route('konseling.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="spesialisasi" class="form-control">
                    <option value="">-- Semua Spesialisasi --</option>
                    <option value="Kesehatan Mental">Kesehatan Mental</option>
                    <option value="Konseling Akademik">Konseling Akademik</option>
                    <option value="Karir">Karir</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($konselors as $k)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $k->nama }}</h5>
                    <p class="text-muted">{{ $k->spesialisasi }}</p>
                    <a href="{{ route('konseling.show', $k->id) }}" class="btn btn-info btn-sm">Lihat Profil</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection