@extends('layouts.app')

@section('title', 'Bookings Hotels')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Daftar Booking Admin</h2>
    <div class="mb-3">
        <a href="{{ route('bookings.create', ['hotel' => $hotel->id ?? 1]) }}" class="btn btn-primary">
            Start Booking
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
            <tr>
                <th>Nama Hotel</th>
                <th>Tanggal Check-in</th>
                <th>Tanggal Check-out</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @php
                $userBookings = $bookings->where('user_id', auth()->id());
            @endphp
            @forelse($userBookings as $booking)
                <tr>
                <td>{{ $booking->room->hotel->name ?? '-' }}</td>
                <td>{{ $booking->check_in }}</td>
                <td>{{ $booking->check_out }}</td>
                <td>
                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($booking->status) }}
                    </span>
                </td>
                </tr>
            @empty
                <tr>
                <td colspan="4" class="text-center">Belum ada booking.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection