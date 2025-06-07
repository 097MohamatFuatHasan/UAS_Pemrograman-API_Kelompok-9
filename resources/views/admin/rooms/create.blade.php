@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Room</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Room --}}
    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Pilih Hotel --}}
        <div class="mb-3">
            <label for="hotel_id" class="form-label">Hotel</label>
            <select class="form-control" id="hotel_id" name="hotel_id" required>
                <option value="">-- Pilih Hotel --</option>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                        {{ $hotel->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Upload Gambar --}}
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Room</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        
        {{-- Tipe Room --}}
        <div class="mb-3">
            <label for="type" class="form-label">Tipe Room</label>
            <input type="text" class="form-control" id="type" name="type" required value="{{ old('type') }}">
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label for="price" class="form-label">Harga per Malam</label>
            <input type="number" class="form-control" id="price" name="price" required value="{{ old('price') }}">
        </div>

        {{-- Kapasitas --}}
        <div class="mb-3">
            <label for="capacity" class="form-label">Kapasitas</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required value="{{ old('capacity') }}">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        {{-- Ketersediaan --}}
        <div class="mb-3">
            <label for="available" class="form-label">Tersedia</label>
            <select class="form-control" id="available" name="available" required>
                <option value="">-- Pilih Status --</option>
                <option value="1" {{ old('available') == '1' ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ old('available') == '0' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Room</button>
    </form>
</div>
@endsection
