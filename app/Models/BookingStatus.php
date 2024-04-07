<?php

namespace App\Models;

use App\Casts\BookingStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id','user_id','status','reason'];

    protected $casts = [
        'status' => BookingStatusCast::class,
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
