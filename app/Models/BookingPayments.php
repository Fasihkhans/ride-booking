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
        "per_minutes_rate",
        "payment_method_id",
        "status"
    ];
    protected $casts = [
        'base_fare' => 'double',
        'per_mile_rate' => 'double',
        'per_minutes_rate' => 'double',
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
