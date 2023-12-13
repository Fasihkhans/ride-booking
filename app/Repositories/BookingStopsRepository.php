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
                         ANY_VALUE(is_favourite) as is_favourite,
                         ANY_VALUE(created_at) as created_at, ANY_VALUE(updated_at) as updated_at')
            ->groupBy('stop')
            ->orderBy('updated_at', 'desc');
    }

    static public function updateIsFav(bool $isFav,int $id)
    {
        $model = BookingStops::findorFail($id);
        $model->is_favourite = $isFav;
        return $model->update();
    }
    public function update(BookingStops $booking,array $data)
    {

    }
}
