<?php

namespace App\Repositories;

use App\Interfaces\IBookingStatusRepository;
use App\Models\BookingStatus;

class BookingStatusRepository implements IBookingStatusRepository
{
    static public function create(array $data)
    {
        return BookingStatus::create($data);
    }

}
