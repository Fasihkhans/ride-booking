<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Interfaces\IBookingRepository;

class BookingRepository implements IBookingRepository
{
    static public function create(array $data)
    {
        return Booking::create($data);
    }

    static public function find(int $id)
    {
        return Booking::find($id);
    }

    static public function findWithStops(int $id)
    {
        return Booking::with('bookingStops')->find($id);
    }
    public function update(Booking $booking,array $data)
    {
        // $driver->license_no = $data['license_no'];
        // $driver->license_expiry = $data['license_expiry'];
        // return $driver->save();
    }
}