<?php

namespace App\Interfaces;

use App\Models\BookingPayments;

interface IBookingPaymentsRepository
{
    static public function create(array $data);

}