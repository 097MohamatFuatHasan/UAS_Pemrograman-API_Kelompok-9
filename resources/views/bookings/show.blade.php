@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<style>
    body {
        background-color: #f2fdf6;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background-color: #198754;
    }

    .card-header h5 {
        margin: 0;
    }

    .badge {
        font-size: 0.95rem;
        padding: 0.4em 0.7em;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-secondary {
        background-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>

<div class="container my-5">
    <h2 class="mb-4 text-success"><i class="bi bi-info-circle-fill me-2"></i>Detail Booking</h2>

    <div class="card mb-4">
        <div class="card-header text-white">
            <h5 class="mb-0">Informasi Booking</h5>
        </div>
        <div class="card-body">
            <h5 class="card-title text-success">{{ $booking->room->hotel->name ?? '-' }}</h5>
            <p><strong>Alamat Hotel:</strong> {{ $booking->room->hotel->address ?? '-' }}</p>
            <p><strong>Nama Pemesan:</strong> {{ $booking->nama_pemesan }}</p>
            <p><strong>Nomor Kamar:</strong> {{ $booking->room->number == 0 ? 'Sedang diproses' : $booking->room->number }}</p>
            <p><strong>Jenis Kamar:</strong> {{ $booking->room->type ?? '-' }}</p>
            <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</p>
            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</p>
            <p><strong>Status:</strong>
                @php
                    $statusClass = match($booking->status) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };
                @endphp
                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
            </p>
        </div>
    </div>

    @if($hasConfirmedBooking)
        <a href="{{ route('ratings.create', ['hotel_id' => $hotel->id]) }}" class="btn btn-warning w-100 mb-4">
            <i class="bi bi-star-fill me-1"></i> Tambah Ulasan
        </a>
    @endif

    <div class="mt-5">
        <h4><i class="bi bi-chat-left-text-fill me-2"></i>Ulasan Terbaru</h4>
        @forelse($hotel->ratings->sortByDesc('created_at')->take(10) as $rating)
            <div class="border rounded p-3 mb-3 bg-light">
                <strong>{{ $rating->user->name ?? 'Anonim' }}</strong>
                <span class="badge bg-info ms-2">{{ $rating->rating }} / 5</span>
                <p class="mt-2">{{ $rating->review }}</p>
                <small class="text-muted">{{ $rating->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p class="text-muted">Belum ada ulasan.</p>
        @endforelse
    </div>

    <a href="{{ route('bookings.index') }}" class="btn btn-secondary mt-4">
        <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Daftar Booking
    </a>
</div>
@endsection
