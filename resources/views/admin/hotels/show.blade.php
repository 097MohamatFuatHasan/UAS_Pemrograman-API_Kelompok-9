
@extends('layouts.app')
@section('title', 'Detail Hotel')

@section('content')
<style>
    body {
        background-color: #f2fdf6;
    }

    .card {
        border-radius: 1rem;
    }

    .card-header {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .img-fluid {
        border-radius: 0.5rem;
    }

    .facility-box {
        background-color: #ffffff;
        border-radius: 0.75rem;
        padding: 0.75rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        text-align: center;
        height: 100%;
    }

    .facility-box img {
        border-radius: 0.5rem;
        object-fit: cover;
    }

    .btn-success {
        background-color: #4CAF50;
        border: none;
    }

    .btn-success:hover {
        background-color: #45a049;
    }

    .rating-badge {
        font-size: 1rem;
        padding: 0.5rem 0.75rem;
    }

    .review-box {
        background-color: #fff;
        border: 1px solid #e1f1e6;
        border-radius: 0.75rem;
    }
</style>

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h2 class="mb-0">{{ $hotel->name }}</h2>
        </div>
        <div class="card-body text-end">
            <a href="{{ route('admin.rooms.create', ['id' => $hotel->id, 'name' => $hotel->name]) }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Room
            </a>
        </div>
        <div class="card-body">

            {{-- Gambar Hotel --}}
            <div class="mb-4">
                <div class="row g-3">
                    @foreach(explode(',', $hotel->image_path) as $image)
                        @php $image = trim($image); @endphp
                        @if(!empty($image) && file_exists(public_path('storage/' . $image)))
                            <div class="col-12">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $hotel->name }}" 
                                    class="img-fluid shadow-sm" style="width: 100%; max-height: 450px;">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Informasi Hotel --}}
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item"><strong>Alamat:</strong> {{ $hotel->address }}</li>
                <li class="list-group-item"><strong>Deskripsi:</strong> {{ $hotel->description }}</li>
                <li class="list-group-item">
                    <strong>Rating:</strong>
                    <span class="badge bg-success rating-badge">{{ number_format($hotel->average_rating, 1) }} / 5</span>
                </li>
            </ul>

            {{-- Fasilitas --}}
            <div class="mb-4">
                <h5 class="mb-3">Fasilitas</h5>
                <div class="row g-3">
                    @foreach($hotel->facilities as $facility)
                        <div class="col-md-4 col-sm-6">
                            <div class="facility-box">
                                <img 
                                    src="{{ isset($facility['image']) && !empty($facility['image']) && file_exists(public_path('storage/' . $facility['image'])) 
                                            ? asset('storage/' . $facility['image']) 
                                            : asset('images/default-facility.png') }}" 
                                    alt="{{ $facility['name'] ?? 'Fasilitas' }}" 
                                    class="img-fluid mb-2" 
                                    style="width: 100%; height: 180px;">
                                <div><strong>{{ $facility['name'] ?? $facility }}</strong></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tombol Booking --}}
            <form action="{{ route('bookings.create', $hotel->id) }}" method="get">
                @csrf
                <button type="submit" class="btn btn-success w-100 py-2 fs-5">
                    <i class="bi bi-calendar-check-fill me-2"></i>Book a Room
                </button>
            </form>

            {{-- Ulasan --}}
            <div class="mt-5">
                <h4>Ulasan Terbaru</h4>
                @forelse($hotel->ratings->sortByDesc('created_at')->take(10) as $rating)
                    <div class="review-box p-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $rating->user->name ?? 'Anonim' }}</strong>
                            <span class="badge bg-info">{{ number_format($rating->rating, 1) }} / 5</span>
                        </div>
                        <p class="mb-1">{{ $rating->review }}</p>
                        <small class="text-muted">{{ $rating->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted">Belum ada ulasan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
