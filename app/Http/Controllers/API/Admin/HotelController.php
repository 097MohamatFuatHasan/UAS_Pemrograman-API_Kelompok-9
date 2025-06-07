<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'facilities.*' => 'nullable|string',
            'facilities_image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $facilityNames = $request->input('facilities', []);
        $facilityImages = [];

        // Upload gambar fasilitas
        if ($request->hasFile('facilities_image')) {
            foreach ($request->file('facilities_image') as $file) {
                $facilityImages[] = $file->store('images/facilities', 'public');
            }
        }

        // Validasi kesesuaian jumlah nama dan gambar
        if (count($facilityNames) !== count($facilityImages)) {
            return back()->withErrors(['Jumlah fasilitas dan gambar harus sama.'])->withInput();
        }

        // Gabungkan fasilitas menjadi satu array objek
        $combinedFacilities = [];
        foreach ($facilityNames as $index => $name) {
            $combinedFacilities[] = [
                'name' => $name,
                'image' => $facilityImages[$index] ?? null,
            ];
        }

        $hotel = new Hotel();
        $hotel->name = $request->name;
        $hotel->address = $request->address;
        $hotel->phone = $request->phone;
        $hotel->email = $request->email;
        $hotel->description = $request->description;
        $hotel->facilities = $combinedFacilities;

        // Upload gambar utama
        if ($request->hasFile('image')) {
            $hotel->image_path = $request->file('image')->store('images/hotels', 'public');
        }

        $hotel->save();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil ditambahkan.');
    }

    public function show($id)
    {
        $hotel = Hotel::with(['rooms', 'ratings.user'])->findOrFail($id);
        
        // Tambahkan properti virtual 'average_rating'
        $hotel->average_rating = $hotel->ratings->avg('rating') ?? 0;

        return view('admin.hotels.show', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'facilities.*' => 'nullable|string',
            'facilities_image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $facilityNames = $request->input('facilities', []);
        $facilityImages = [];

        if ($request->hasFile('facilities_image')) {
            foreach ($request->file('facilities_image') as $file) {
                $facilityImages[] = $file->store('images/facilities', 'public');
            }
        }

        // Gabungkan nama dan gambar
        $combinedFacilities = [];
        foreach ($facilityNames as $index => $name) {
            $combinedFacilities[] = [
                'name' => $name,
                'image' => $facilityImages[$index] ?? ($hotel->facilities[$index]['image'] ?? null),
            ];
        }

        $hotel->name = $request->name;
        $hotel->address = $request->address;
        $hotel->phone = $request->phone;
        $hotel->email = $request->email;
        $hotel->description = $request->description;
        $hotel->facilities = $combinedFacilities;

        if ($request->hasFile('image')) {
            $hotel->image_path = $request->file('image')->store('images/hotels', 'public');
        }

        $hotel->save();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        // Optional: hapus gambar utama dan gambar fasilitas dari storage
        if ($hotel->image_path && Storage::exists('public/' . $hotel->image_path)) {
            Storage::delete('public/' . $hotel->image_path);
        }

        if (is_array($hotel->facilities)) {
            foreach ($hotel->facilities as $facility) {
                if (isset($facility['image']) && Storage::exists('public/' . $facility['image'])) {
                    Storage::delete('public/' . $facility['image']);
                }
            }
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil dihapus.');
    }
}
