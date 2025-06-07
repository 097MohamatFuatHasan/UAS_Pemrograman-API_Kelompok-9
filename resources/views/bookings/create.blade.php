@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white rounded-top-4">
            <h2 class="mb-0"><i class="bi bi-bookmark-check"></i> Buat Booking Baru</h2>
            <p class="mb-0">Hotel: <strong>{{ $hotel->name }}</strong></p>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('bookings.store', ['hotel' => $hotel->id]) }}" method="POST" id="bookingForm">
                @csrf

                <div class="mb-3">
                    <label for="hotel_name" class="form-label"><i class="bi bi-building"></i> Nama Hotel</label>
                    <input type="text" class="form-control" id="hotel_name" name="hotel_name" value="{{ $hotel->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_pemesan" class="form-label"><i class="bi bi-person"></i> Nama Pemesan</label>
                    <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
                </div>

                <div class="mb-3">
                    <label for="room_type" class="form-label"><i class="bi bi-door-open"></i> Tipe Kamar</label>
                    <select class="form-select" id="room_type" name="room_type" required>
                        <option value="">Pilih Tipe Room</option>
                        @php $types = $rooms->pluck('type')->unique(); @endphp
                        @foreach($types as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="room_id" class="form-label"><i class="bi bi-hash"></i> Nomor Kamar</label>
                    <select class="form-select" id="room_id" name="room_id" required>
                        <option value="">Pilih Nomor Room</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="check_in" class="form-label"><i class="bi bi-calendar-check"></i> Check In</label>
                        <input type="date" class="form-control" id="check_in" name="check_in" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="check_out" class="form-label"><i class="bi bi-calendar-x"></i> Check Out</label>
                        <input type="date" class="form-control" id="check_out" name="check_out" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="check_in_time" class="form-label"><i class="bi bi-clock-history"></i> Jam Check In</label>
                        <input type="time" class="form-control" id="check_in_time" name="check_in_time" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="check_out_time" class="form-label"><i class="bi bi-clock"></i> Jam Check Out</label>
                        <input type="time" class="form-control" id="check_out_time" name="check_out_time" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="guests" class="form-label"><i class="bi bi-people-fill"></i> Jumlah Tamu</label>
                        <input type="number" class="form-control" id="guests" name="guests" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="total_price" class="form-label"><i class="bi bi-cash-stack"></i> Total Harga</label>
                        <input type="number" class="form-control" id="total_price" name="total_price" required readonly>
                    </div>
                </div>

                <input type="hidden" name="status" value="pending">

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg rounded-3"><i class="bi bi-check2-circle"></i> Konfirmasi Booking</button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-white border-top-0 rounded-bottom-4 text-center">
            <h4 class="mb-0">Total Harga: <span id="display_total_price" class="text-success fw-bold">Rp0</span></h4>
        </div>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@push('scripts')
<script>
    const rooms = @json($rooms);
    const roomTypeSelect = document.getElementById('room_type');
    const roomNumberSelect = document.getElementById('room_id');

    roomTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        roomNumberSelect.innerHTML = '<option value="">Pilih Nomor Room</option>';
        if (selectedType) {
            const filteredRooms = rooms.filter(room => room.type === selectedType);
            filteredRooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = `No: ${room.number} - Kapasitas: ${room.capacity} - Rp${Number(room.price).toLocaleString('id-ID')}`;
                option.setAttribute('data-price', room.price);
                roomNumberSelect.appendChild(option);
            });
        }
        calculateTotalPrice();
    });

    roomNumberSelect.addEventListener('change', calculateTotalPrice);
    document.getElementById('check_in').addEventListener('change', calculateTotalPrice);
    document.getElementById('check_out').addEventListener('change', calculateTotalPrice);

    function calculateTotalPrice() {
        const roomSelect = document.getElementById('room_id');
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;
        const totalPriceInput = document.getElementById('total_price');
        const displayTotal = document.getElementById('display_total_price');

        let price = 0;
        let days = 1;

        if (roomSelect.value) {
            price = parseInt(roomSelect.options[roomSelect.selectedIndex].getAttribute('data-price')) || 0;
        }

        if (checkIn && checkOut) {
            const date1 = new Date(checkIn);
            const date2 = new Date(checkOut);
            days = (date2 - date1) / (1000 * 60 * 60 * 24);
            days = days > 0 ? days : 1;
        }

        const total = price * days;
        totalPriceInput.value = total;
        displayTotal.textContent = 'Rp' + total.toLocaleString('id-ID');
    }
</script>
@endpush
@endsection
