<?php
namespace App\Http\Controllers;

use App\Models\Hotel;

class HomeController extends Controller
{
    public function index()
    {
        $featuredHotels = Hotel::with('ratings')->get();

        // Tambahkan properti virtual 'average_rating'
        $featuredHotels->map(function ($hotel) {
            $hotel->average_rating = $hotel->ratings->avg('rating') ?? 0;
            return $hotel;
        });

        return view('home', compact('featuredHotels'));
    }

}
