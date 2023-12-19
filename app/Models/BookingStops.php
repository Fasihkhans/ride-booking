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
        "is_favourite",
        "status",
        "driver_latitude",
        "driver_longitude",
        "type"
    ];

    protected $cast = [
        "stop"=> "string",
        "latitude"=> "integer",
        "longitude" => "integer",
        "sequence_no" => "interger",
        "is_favourite" => 'boolean',
        "driver_latitude" => "integer",
        "driver_longitude" => "integer",
        "type" => "string"
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
