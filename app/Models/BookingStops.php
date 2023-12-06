<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStops extends Model
{
    use HasFactory;

    protected $fillable = [
        "booking_id",
        "stop",
        "latitude",
        "longitude",
        "sequence_no",
        "status"
    ];

    protected $cast = [
        "stop"=> "string",
        "latitude"=> "integer",
        "longitude" => "integer",
        "sequence_no" => "interger"
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}