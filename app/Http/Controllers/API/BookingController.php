<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Mengambil semua booking dengan relasi user dan room untuk efisiensi query
        $bookings = Booking::with(['user', 'room'])->orderBy('check_in', 'desc')->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function store($hotelId, Request $request)
    {
        // Cari hotel
        $hotel = Hotel::findOrFail($hotelId);

        // Validasi request input
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
        ]);

        // Pastikan kamar milik hotel yang dipilih
        $room = $hotel->rooms()->findOrFail($request->room_id);

        // Cek ketersediaan kamar pada tanggal booking
        if ($room->numer != 0) {
    // Cek apakah kamar sudah dipesan di tanggal yang sama
            $isBooked = Booking::where('room_id', $room->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('check_in', '<', $request->check_in)
                                ->where('check_out', '>', $request->check_out);
                        });
                })->exists();

            if ($isBooked) {
                return back()->withErrors(['room_id' => 'Kamar sudah dipesan pada tanggal tersebut.'])->withInput();
            }
        }

        // Hitung total harga
        $days = (strtotime($request->check_out) - strtotime($request->check_in)) / (60 * 60 * 24);
        $totalPrice = $days * $room->price;

        // Simpan booking
        $booking = Booking::create([
            'nama_pemesan' => $request->nama_pemesan,
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat!');
    }


    public function show($id)
    {
        $booking = Booking::with('room.hotel')->findOrFail($id);

        $hotel = $booking->room->hotel;

        // Cek apakah user punya booking yang dikonfirmasi untuk hotel ini
        $hasConfirmedBooking = auth()->user()->bookings()
        ->where('status', 'confirmed')
        ->whereHas('room.hotel', function ($query) use ($hotel) {
            $query->where('id', $hotel->id);
        })->exists();


        return view('bookings.show', compact('booking', 'hotel', 'hasConfirmedBooking'));
    }

    public function create($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        $rooms = $hotel->rooms; // Fetch rooms for the hotel
        return view('bookings.create', compact('hotel', 'rooms'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Only pending bookings can be cancelled'], 400);
        }

        $booking->update(['status' => 'cancelled']);
        return response()->json($booking);
    }
}