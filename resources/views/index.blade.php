<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Konselor - MindFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Cari Konselor</h2>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('konseling.index') }}" method="GET" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="spesialisasi" class="form-control" 
                               placeholder="Cari spesialisasi (misal: Depresi, Kecemasan...)" 
                               value="{{ request('spesialisasi') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($konselors as $k)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $k->user->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <span class="badge bg-info text-dark">{{ $k->spesialisasi }}</span>
                            </h6>
                            <p class="card-text text-truncate">{{ $k->biografi }}</p>
                            <a href="{{ route('konseling.show', $k->profil_konselor_id) }}" 
                               class="btn btn-outline-primary btn-sm">Lihat Profil Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">Konselor dengan spesialisasi tersebut tidak ditemukan.</div>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>