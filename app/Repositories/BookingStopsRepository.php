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

    static public function findLatestStops(int $userId)
    {
        return BookingStops::whereHas('booking', function ($query) use ($userId) {
            $query->where('customer_id', $userId);
        })
            ->select( 'stop')
            ->selectRaw('ANY_VALUE(id) as id, ANY_VALUE(booking_id) as booking_id, ANY_VALUE(status) as status ,
                         ANY_VALUE(latitude) as latitude, ANY_VALUE(longitude) as longitude, MAX(sequence_no) as sequence_no,
                         ANY_VALUE(created_at) as created_at, ANY_VALUE(updated_at) as updated_at')
            ->groupBy('stop')
            ->orderBy('sequence_no', 'asc');
    }


    public function update(BookingStops $booking,array $data)
    {
        // $driver->license_no = $data['license_no'];
        // $driver->license_expiry = $data['license_expiry'];
        // return $driver->save();
    }
}
