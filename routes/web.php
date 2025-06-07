<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\API\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\API\Admin\RoomsController as AdminRoomController;
use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\RoomController;


// Homepage
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Public hotel pages


// Authenticated user routes
Route::middleware('auth')->group(function () {
    // List booking dan detail booking
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // Buat booking, harus ada hotel sebagai parameter
    Route::get('/bookings/create/{hotel}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/{hotel}', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
    Route::get('/hotels/{hotel}/rooms/{room}', [RoomController::class, 'show'])->name('hotels.rooms.show');

    // Rate hotel
    Route::get('/ratings/create', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/ratings/{rating}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});


// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Hotels
    Route::get('/hotels', [AdminHotelController::class, 'index'])->name('admin.hotels.index');
    Route::get('/hotels/create', [AdminHotelController::class, 'create'])->name('admin.hotels.create');
    Route::post('/hotels', [AdminHotelController::class, 'store'])->name('admin.hotels.store');
    Route::get('/hotels/{hotel}/edit', [AdminHotelController::class, 'edit'])->name('admin.hotels.edit');
    Route::put('/hotels/{hotel}', [AdminHotelController::class, 'update'])->name('admin.hotels.update');
    Route::delete('/hotels/{hotel}', [AdminHotelController::class, 'destroy'])->name('admin.hotels.destroy');
    Route::get('/hotels/{hotel}', [AdminHotelController::class, 'show'])->name('admin.hotels.show');

    // Rooms
    Route::get('/rooms', [AdminRoomController::class, 'index'])->name('admin.rooms.index');

    // Untuk form tambah room global (pakai select hotel)
    Route::get('/rooms/create', [AdminRoomController::class, 'create'])->name('admin.rooms.create');

    // Untuk form tambah room spesifik hotel (opsional, jika kamu mau)
    Route::get('/hotels/{hotel}/rooms/create', [AdminRoomController::class, 'createForHotel'])->name('admin.rooms.create.for_hotel');

    Route::post('/rooms', [AdminRoomController::class, 'store'])->name('admin.rooms.store');
    Route::get('/rooms/{room}/edit', [AdminRoomController::class, 'edit'])->name('admin.rooms.edit');
    Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('admin.rooms.destroy');
    Route::get('/rooms/{room}', [AdminRoomController::class, 'show'])->name('admin.rooms.show');

    
    // Bookings
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/bookings', [AdminBookingController::class, 'index']);
    Route::get('/admin/bookings/{id}', [AdminBookingController::class, 'show']);
    Route::put('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm']);
    Route::put('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel']);
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
});