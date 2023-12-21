<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        "booking_id",
        "base_fare",
        "per_mile_rate",
        "per_minute_rate",
        "payment_method_id",
        "status",
        "peak_hour_rate",
        "holiday_rate",
        "total_minutes",
        "total_miles",
        "total_fare",

    ];
    protected $casts = [
        'base_fare' => 'double',
        'per_mile_rate' => 'double',
        'per_minute_rate' => 'double',
        'peak_hour_rate'=> 'double',
        'holiday_rate'=> 'double',
        'total_minutes'=> 'double',
        'total_miles'=> 'double',
        'total_fare'=> 'double',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class,"booking_id");
    }

    public function paymentMethod()
    {
        return $this->belongsTo(CustomerPaymentMethods::class, 'payment_method_id');
    }
}