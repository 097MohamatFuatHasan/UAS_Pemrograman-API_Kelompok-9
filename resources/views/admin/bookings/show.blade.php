@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Booking Admin</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Informasi Booking
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $booking->room->hotel->name ?? '-' }}</h5>

            <p><strong>Alamat Hotel:</strong> {{ $booking->room->hotel->address ?? '-' }}</p>
            <p><strong>Nama Pemesan:</strong> {{ $booking->nama_pemesan }}</p>
            <p><strong>Nomer Kamar: </strong>{{$booking->room->number == 0 ? 'Sedang diproses' :$booking->room->number }}</p>
            
            <p><strong>Room:</strong> {{ $booking->room->type ?? '-' }}</p>
            <p><strong>Tanggal Check-in:</strong> {{ $booking->check_in }}</p>
            <p><strong>Tanggal Check-out:</strong> {{ $booking->check_out }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </p>
        </div>
    </div>

    <a href="{{ route('bookings.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Booking</a>
</div>
@endsection
