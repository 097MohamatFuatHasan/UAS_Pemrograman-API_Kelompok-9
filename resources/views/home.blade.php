@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section mb-5 text-white d-flex align-items-center">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold">Find Your Perfect Stay</h1>
        <p class="lead">Book hotels with best prices and exclusive deals</p>
        @auth
            <a href="{{ route('hotels.index') }}" class="btn btn-success btn-lg px-4">Search Hotels</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Login to Book Now</a>
        @endauth
    </div>
</div>

<div class="container mt-4">
    <h2 class="mb-4 fw-semibold text-success">Featured Hotels</h2>
    <div class="row">
        @forelse($featuredHotels->sortByDesc('average_rating')->take(3) as $hotel)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 d-flex flex-column">
                    <img src="{{ $hotel->image_path && file_exists(public_path('storage/' . $hotel->image_path)) 
                                ? asset('storage/' . $hotel->image_path) 
                                : asset('images/no-image.png') }}"
                         class="card-img-top" 
                         alt="{{ $hotel->name }}" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-success">{{ $hotel->name }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($hotel->description, 100) }}</p>
                        <p class="text-muted small">{{ $hotel->address }}</p>

                        <!-- RATING BINTANG -->
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($hotel->average_rating))
                                    <span class="text-warning">&#9733;</span>
                                @else
                                    <span class="text-secondary">&#9733;</span>
                                @endif
                            @endfor
                            <span class="ms-2 text-muted">({{ number_format($hotel->average_rating, 1) }})</span>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-outline-success btn-sm w-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No featured hotels available.</p>
        @endforelse
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-4 fw-semibold text-success">Hotel Carousel</h2>
    @if($featuredHotels->count())
    <div id="hotelCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($featuredHotels as $index => $hotel)
            <div class="carousel-item @if($index == 0) active @endif">
                <div class="d-flex flex-column align-items-center">
                    <img src="{{ $hotel->image_path && file_exists(public_path('storage/' . $hotel->image_path)) 
                                ? asset('storage/' . $hotel->image_path) 
                                : asset('images/no-image.png') }}" 
                         class="d-block w-100 rounded shadow-sm" 
                         alt="{{ $hotel->name }}" 
                         style="max-height: 300px; object-fit: cover;">
                    <div class="mt-3 text-center">
                        <h5 class="text-success">{{ $hotel->name }}</h5>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($hotel->average_rating))
                                    <span class="text-warning">&#9733;</span>
                                @else
                                    <span class="text-secondary">&#9733;</span>
                                @endif
                            @endfor
                            <span class="ms-2 text-muted">({{ number_format($hotel->average_rating, 1) }})</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @else
        <p class="text-muted">No hotels to display in carousel.</p>
    @endif
</div>

<style>
.hero-section {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    min-height: 70vh;
    border-radius: 0.5rem;
}

.card:hover {
    transform: scale(1.02);
    transition: 0.3s ease;
}

.btn-success {
    background-color: #66bb6a;
    border-color: #66bb6a;
}

.btn-success:hover {
    background-color: #4caf50;
    border-color: #4caf50;
}
</style>
@endsection
