@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard Overview</h2>
    <div class="text-muted">Today: {{ now()->format('F j, Y') }}</div>
</div>

<div class="row mb-4">
    @php
        $cards = [
            ['title' => 'Total Hotels', 'value' => $stats['total_hotels'] ?? 0, 'class' => 'primary'],
            ['title' => 'Total Rooms', 'value' => $stats['total_rooms'] ?? 0, 'class' => 'success'],
            ['title' => 'Total Bookings', 'value' => $stats['total_bookings'] ?? 0, 'class' => 'info'],
            ['title' => 'Total Users', 'value' => $stats['total_users'] ?? 0, 'class' => 'warning'],
        ];
    @endphp

    @foreach ($cards as $card)
        <div class="col-md-3 mb-3">
            <div class="card bg-{{ $card['class'] }} text-white">
                <div class="card-body">
                    <h5 class="card-title">{{ $card['title'] }}</h5>
                    <h2 class="card-text">{{ $card['value'] }}</h2>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5>Today's Activity</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Check-ins</h6>
                                <h3>{{ $stats['today_check_ins'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Check-outs</h6>
                                <h3>{{ $stats['today_check_outs'] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Recent Bookings</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Hotel</th>
                        <th>Room</th>
                        <th>Guest</th>
                        <th>Dates</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_bookings'] ?? [] as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->room->hotel->name ?? '-' }}</td>
                            <td>{{ $booking->room->type ?? '-' }}</td>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>
                                {{ optional($booking->check_in)->format('M d') ?? '-' }} -
                                {{ optional($booking->check_out)->format('M d') ?? '-' }}
                            </td>
                            <td>${{ number_format($booking->total_price ?? 0, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = match($booking->status) {
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'warning'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                </a>
                                @if($booking->status === 'pending')
                                    <button 
                                        class="btn btn-sm btn-outline-success btn-confirm-booking" 
                                        data-id="{{ $booking->id }}" 
                                        title="Confirm"
                                        type="button"
                                    >
                                        <i class="bi bi-check-circle" aria-hidden="true"></i>
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-outline-danger btn-cancel-booking" 
                                        data-id="{{ $booking->id }}" 
                                        title="Cancel"
                                        type="button"
                                    >
                                        <i class="bi bi-x-circle" aria-hidden="true"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No recent bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Confirm Booking langsung tanpa modal
    document.querySelectorAll('.btn-confirm-booking').forEach(function(button) {
        button.addEventListener('click', function () {
            const bookingId = this.getAttribute('data-id');

            fetch(`/admin/bookings/${bookingId}/confirm`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Gagal mengonfirmasi booking.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat mengonfirmasi.'));
        });
    });

    // Cancel Booking
    document.querySelectorAll('.btn-cancel-booking').forEach(function(btn) {
        btn.addEventListener('click', function() {
            let bookingId = this.getAttribute('data-id');
            if(confirm('Are you sure you want to cancel this booking?')) {
                fetch(`/admin/bookings/${bookingId}/cancel`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to cancel booking.');
                    }
                })
                .catch(() => alert('Error cancelling booking.'));
            }
        });
    });
});
</script>
@endpush

@endsection
