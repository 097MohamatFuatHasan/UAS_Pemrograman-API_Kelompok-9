@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kamar Hotel</h2>
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mb-3">Tambah Kamar</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hotel</th>
                <th>Nomor Kamar</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Kapasitas</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
            <tr>
                <td>{{ $room->hotel->name ?? 'Tidak diketahui' }}</td>
                <td>{{ $room->number ?? '-' }}</td> {{-- Jika ada kolom nomor --}}
                <td>{{ $room->type }}</td>
                <td>Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                <td>{{ $room->capacity }}</td>
                <td>{{ Str::limit($room->description, 50) }}</td>
                <td>
                    @if($room->available)
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Tidak tersedia</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kamar ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada kamar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
