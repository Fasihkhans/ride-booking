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

    /**
     * mark isfavourite stop true / false
     *
     * @param bool $isFav
     * @param int $id
     * @return bool
     */
    static public function updateIsFav(bool $isFav,int $id):bool
    {
        $model = BookingStops::findorFail($id);
        if (!$model)
            return false;
        $model->is_favourite = $isFav;
        return $model->update();
    }

    /**
     * Add driver coordinates on pickup point
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $id
     * @return bool
     */
    static public function addDriverPickUpCoordinates(float $latitude,float $longitude,int $id): bool
    {
        $model = BookingStops::where(['booking_id'=>$id, 'type' => 'pickUp'])->first();
        if (!$model)
            return false;
        $model->driver_latitude = $latitude;
        $model->driver_longitude = $longitude;
        return $model->save();
    }

    /**
     * Add driver coordinates on dropOff point
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $id
     * @return bool
     */
    static public function addDriverDropOffCoordinates(float $latitude,float $longitude,int $id): bool
    {
        $model = BookingStops::where(['booking_id'=>$id, 'type' => 'dropOff'])->first();
        if (!$model)
            return false;
        $model->driver_latitude = $latitude;
        $model->driver_longitude = $longitude;
        return $model->save();
    }
    public function update(BookingStops $booking,array $data)
    {
        //
    }
}