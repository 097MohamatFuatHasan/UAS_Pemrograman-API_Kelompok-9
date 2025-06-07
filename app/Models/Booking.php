<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pemesan', 'user_id', 'room_id', 'hotel_name', 'check_in', 'check_out', 'guests', 'total_price', 'status', 'check_in_time', 'check_out_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    

    public function hotel()
    {
        // Relasi melalui room ke hotel
        return $this->room ? $this->room->hotel : null;
    }

    /**
     * Accessor untuk mendapatkan nama hotel.
     */
    public function getHotelNameAttribute()
    {
        return $this->room && $this->room->hotel ? $this->room->hotel->name : null;
    }
}