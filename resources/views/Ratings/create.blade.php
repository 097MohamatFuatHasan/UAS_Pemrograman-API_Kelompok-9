@extends('layouts.app')
@section('title', 'Tambah Ulasan')
@section('content')
<div class="container mt-5">
    <h2>Tambah Ulasan untuk {{ $hotel->name }}</h2>

    <form action="{{ route('ratings.store') }}" method="POST">
        @csrf
        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
        
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea name="review" id="review" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
    </form>
</div>
@endsection
