<?php

namespace App\Repositories;

use App\Models\BookingStops;
use App\Interfaces\IBookingStopsRepository;

class BookingStopsRepository implements IBookingStopsRepository
{
    static public function create(array $data)
    {
        return BookingStops::create($data);
    }

    public function update(BookingStops $booking,array $data)
    {
        // $driver->license_no = $data['license_no'];
        // $driver->license_expiry = $data['license_expiry'];
        // return $driver->save();
    }
}