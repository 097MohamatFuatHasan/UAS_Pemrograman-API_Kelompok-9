@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Hotel Baru</h2>

    {{-- Tampilkan pesan error validasi --}}
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

    <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Hotel</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Hotel</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Utama Hotel</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        {{-- Fasilitas --}}
        <div id="facility-container">
            <label class="form-label">Fasilitas & Gambar:</label>
            <div class="row mb-2">
                <div class="col-md-6">
                    <input type="text" name="facilities[]" class="form-control" placeholder="Nama fasilitas">
                </div>
                <div class="col-md-6">
                    <input type="file" name="facilities_image[]" class="form-control">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-success mb-3" onclick="addFacility()">+ Tambah Fasilitas</button>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

{{-- Tambahkan JavaScript untuk menambah fasilitas --}}
<script>
    function addFacility() {
        const container = document.getElementById('facility-container');
        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="facilities[]" class="form-control" placeholder="Nama fasilitas">
            </div>
            <div class="col-md-6">
                <input type="file" name="facilities_image[]" class="form-control">
            </div>
        `;
        container.appendChild(row);
    }
</script>
@endsection
