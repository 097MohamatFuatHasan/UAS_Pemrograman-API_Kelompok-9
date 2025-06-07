<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    
    public function create(Request $request)
    {
        $hotel = Hotel::findOrFail($request->hotel_id);
        $user = auth()->user();

        // Cek apakah user pernah booking room di hotel ini dengan status 'confirmed'
        $hasBooked = $user->bookings()
        ->where('status', 'confirmed')
        ->whereHas('room.hotel', function ($query) use ($hotel) {
            $query->where('hotel_id', $hotel->id);
        })->exists();


        if (!$hasBooked) {
            return redirect()->route('hotels.show', $hotel->id)
                ->with('error', 'Anda harus memesan hotel ini terlebih dahulu untuk memberikan ulasan.');
        }

        return view('ratings.create', compact('hotel'));
    }



    public function store(Request $request)
{
    $request->validate([
        'rating' => 'required|numeric|min:1|max:5',
        'review' => 'required|string',
        'hotel_id' => 'required|exists:hotels,id',
    ]);

    $user = auth()->user();

    // Cek booking user di hotel ini dengan status confirmed
    $hasBooked = $user->bookings()
        ->where('status', 'confirmed')
        ->whereHas('room', function ($query) use ($request) {
            $query->where('hotel_id', $request->hotel_id);
        })
        ->exists();

    if (!$hasBooked) {
        return redirect()->route('hotels.show', $request->hotel_id)
            ->with('error', 'Anda tidak berhak memberikan ulasan untuk hotel ini.');
    }

    Rating::create([
        'user_id' => $user->id,
        'rateable_type' => 'App\Models\Hotel',
        'rateable_id' => $request->hotel_id,
        'rating' => $request->rating,
        'review' => $request->review,
    ]);

    return redirect()->route('hotels.show', $request->hotel_id)
        ->with('success', 'Ulasan berhasil ditambahkan.');
}



    public function edit(Rating $rating)
    {
        $this->authorize('update', $rating);
        return view('ratings.edit', compact('rating'));
    }

    public function update(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string',
        ]);

        $rating->update($request->only('rating', 'review'));

        return back()->with('success', 'Ulasan diperbarui.');
    }

    public function destroy(Rating $rating)
    {
        $this->authorize('delete', $rating);
        $rating->delete();
        return back()->with('success', 'Ulasan dihapus.');
    }
}
