<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\Admin\BookingController as AdminBookingController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // User routes
    Route::get('/hotels', [HotelController::class, 'index']);
    Route::get('/hotels/{id}', [HotelController::class, 'show']);
    
    Route::get('/rooms/available', [RoomController::class, 'available']);
    Route::get('/rooms/{id}', [RoomController::class, 'show']);
    
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancel']);

    // Rating routes
    Route::post('/hotels/{id}/rate', [RatingController::class, 'rateHotel']);
    Route::post('/rooms/{id}/rate', [RatingController::class, 'rateRoom']);
    Route::get('/hotels/{id}/ratings', [RatingController::class, 'getHotelRatings']);
    Route::get('/rooms/{id}/ratings', [RatingController::class, 'getRoomRatings']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('/admin/hotels', HotelController::class)->except(['index', 'show']);
        Route::apiResource('/admin/rooms', RoomController::class)->except(['index', 'show']);
        
        Route::get('/admin/dashboard', [DashboardController::class, 'index']);
        Route::get('/admin/bookings', [AdminBookingController::class, 'index']);
        Route::get('/admin/bookings/{id}', [AdminBookingController::class, 'show']);
        Route::put('/admin/bookings/{id}/confirm', [AdminBookingController::class, 'confirm']);
        Route::put('/admin/bookings/{id}/cancel', [AdminBookingController::class, 'cancel']);
    });
});
