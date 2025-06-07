@extends('layouts.app')

@section('title', 'Bookings Hotels')

@section('content')
<style>
    body {
        background-color: #f2fdf6;
    }

    .table thead th {
        background-color: #4CAF50;
        color: white;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .btn-primary {
        background-color: #198754;
        border: none;
    }

    .btn-primary:hover {
        background-color: #157347;
    }
</style>

<div class="container my-5">
    <div class="card p-4">
        <h2 class="mb-4 text-success"><i class="bi bi-journal-bookmark-fill me-2"></i>Daftar Booking Anda</h2>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Hotel</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $userBookings = $bookings->where('user_id', auth()->id());
                @endphp
                @forelse($userBookings as $booking)
                    <tr>
                        <td>{{ $booking->room->hotel->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                        <td>
                            @php
                                $statusClass = match($booking->status) {
                                    'confirmed' => 'success',
                                    'pending' => 'warning',
                                    'cancelled' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye-fill me-1"></i>Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada booking.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
