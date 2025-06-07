<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_hotels' => Hotel::count(),
        'total_rooms' => Room::count(),
        'total_bookings' => Booking::count(),
        // 'active_users' removed due to missing 'last_login_at' column
        'today_check_ins' => Booking::whereDate('check_in', today())->count(),
        'today_check_outs' => Booking::whereDate('check_out', today())->count(),
        'revenue' => [
            'today' => Booking::whereDate('created_at', today())->sum('total_price'),
            'month' => Booking::whereMonth('created_at', now()->month)->sum('total_price'),
            'year' => Booking::whereYear('created_at', now()->year)->sum('total_price'),
        ],
        'recent_bookings' => Booking::with(['room.hotel', 'user'])->latest()->take(10)->get(),
    ];
    return view('admin.dashboard', compact('stats'));
    }
}