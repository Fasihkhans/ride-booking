<?php

namespace App\Models;

use App\Casts\BookingStatusCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "customer_id",
        "driver_id",
        "vehicle_id",
        "type",
        "status",
    ];

    protected $casts = [
        'status' => BookingStatusCast::class,
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, "customer_id");
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, "driver_id");
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicles::class, "vehicle_id");
    }

    public function bookingPayment()
    {
        return $this->hasOne(BookingPayments::class);
    }

    public function bookingStops()
    {
        return $this->hasMany(BookingStops::class);
    }

}
