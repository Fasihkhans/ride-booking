<?php

namespace App\Interfaces;

use App\Models\Booking;
use App\Models\BookingPayments;

interface IBookingPaymentsRepository
{
    static public function create(Booking $booking);

}
