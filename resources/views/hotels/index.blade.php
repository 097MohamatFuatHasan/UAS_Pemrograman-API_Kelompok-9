@extends('layouts.app')

@section('title', 'Browse Hotels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Browse Hotels</h1>
    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="bi bi-funnel"></i> Filters
    </button>
</div>

<div class="row" id="hotels-container">
    @foreach($hotels as $hotel)
        <div class="col-md-4 mb-4">
            <div class="card h-100 d-flex flex-column justify-content-between hotel-card">
                <div>
                    <div class="hotel-image" style="background-image: url({{ $hotel->image_path && file_exists(public_path('storage/' . $hotel->image_path)) ? asset('storage/' . $hotel->image_path) : asset('images/no-image.png') }})">
                        <div class="rating-badge">
                            {{ number_format($hotel->average_rating, 1) }} <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                        <p class="card-text text-muted">
                            <i class="bi bi-geo-alt"></i> {{ $hotel->address }}
                        </p>
                        <div class="amenities mb-3">
                            @foreach(($hotel->facilitiesArray ?? []) as $facility)
                                <span class="badge bg-light text-dark me-1 mb-1">{{ $facility }}</span>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-sm btn-primary w-100">
                        View <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $hotels->appends(request()->input())->links() }}
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('hotels.index') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Hotels</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" value="{{ request('location') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select class="form-select" name="rating">
                            <option value="">Any Rating</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                    {{ $i }}+ Stars
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price Range</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Min" name="min_price" value="{{ request('min_price') }}">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Max" name="max_price" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Facilities</label>
                        <div class="row">
                            @foreach(['Pool', 'WiFi', 'Restaurant', 'Spa', 'Gym', 'Parking'] as $facility)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" 
                                               value="{{ $facility }}" id="facility-{{ Str::slug($facility) }}"
                                               {{ in_array($facility, request('facilities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="facility-{{ Str::slug($facility) }}">
                                            {{ $facility }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('hotels.index') }}" class="btn btn-outline-danger">Reset</a>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(input => {
            if (!input.value) {
                input.value = today;
            }
            input.min = today;
        });
    });
</script>
@endsection

<style>
.hotel-card {
    transition: transform 0.2s;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.hotel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.hotel-image {
    height: 200px;
    background-size: cover;
    background-position: center;
    position: relative;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}
.rating-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.9rem;
}
.rating-badge i {
    color: #ffc107;
}
</style>
