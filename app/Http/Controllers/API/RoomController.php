<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Menampilkan semua room (opsional bisa tambahkan filter hotel_id)
    public function index()
    {
        $rooms = Room::all();
        $hotels = Hotel::all();
        return view('admin.rooms.index', compact('rooms', 'hotels'));
    }

    // Form tambah room (dropdown hotel)
    public function create()
    {
        $hotels = Hotel::all();
        return view('admin.rooms.create', compact('hotels'));
    }

    // Simpan room baru
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'available' => 'required|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/rooms', 'public');
        }

        Room::create([
            'hotel_id' => $request->hotel_id,
            'type' => $request->type,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'image' => $imagePath,
            'available' => $request->available,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room berhasil ditambahkan.');
    }

    // Detail 1 room (API/json)
    public function show($id)
    {
        $room = Room::with('hotel')->findOrFail($id);
        return response()->json($room);
    }

    // Form edit room
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $hotels = Hotel::all();
        return view('admin.rooms.edit', compact('room', 'hotels'));
    }

    // Update room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'available' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($room->image && Storage::exists('public/' . $room->image)) {
                Storage::delete('public/' . $room->image);
            }
            $room->image = $request->file('image')->store('images/rooms', 'public');
        }

        $room->update([
            'hotel_id' => $request->hotel_id,
            'type' => $request->type,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'available' => $request->available,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room berhasil diperbarui.');
    }

    // Hapus room
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        if ($room->image && Storage::exists('public/' . $room->image)) {
            Storage::delete('public/' . $room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room berhasil dihapus.');
    }
}