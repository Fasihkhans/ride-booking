<?php

namespace App\Interfaces;

use App\Models\BookingStatus;

interface IBookingStatusRepository
{
    static public function create(array $data);
}
