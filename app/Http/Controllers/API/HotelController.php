<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
{
    $query = Hotel::with('ratings');

    if ($request->filled('location')) {
        $query->where('address', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('min_price')) {
        $query->where('min_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('min_price', '<=', $request->max_price);
    }

    if ($request->has('facilities')) {
        foreach ($request->facilities as $facility) {
            $query->where('facilities', 'like', '%' . $facility . '%');
        }
    }

    $hotels = $query->paginate(9)->appends($request->except('page'));

    // Transform dan filter berdasarkan rating tanpa mengubah tipe data
    $hotels->getCollection()->transform(function ($hotel) use ($request) {
        $hotel->average_rating = $hotel->ratings->avg('rating') ?? 0;
        return $hotel;
    });

    // Jika ingin filter rating, lakukan di view (atau pakai Livewire untuk interaktif)

    return view('hotels.index', compact('hotels'));
}



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $hotel = Hotel::create($request->all());
        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show($id)
    {
        $hotel = Hotel::with(['rooms', 'ratings.user'])->findOrFail($id);
        
        // Tambahkan properti virtual 'average_rating'
        $hotel->average_rating = $hotel->ratings->avg('rating') ?? 0;

        return view('hotels.show', compact('hotel'));
    }




    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy($id)
    {
        Hotel::findOrFail($id)->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
