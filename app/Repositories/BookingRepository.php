<?php

namespace App\Repositories;

use App\Constants\Constants;
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
    static public function findDriverForBooking(int $vehicleId,int $driverId)
    {
        return Booking::where(['vehicle_id'=>$vehicleId,'driver_id'=>$driverId])
                ->whereNotIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])
                ->get();
    }

    static public function updateStatus(int $status,int $id)
    {
        $model = Booking::find($id);
        $model->status = $status;
        return $model->update();
    }

    static public function assignDriver(int $driverId,int $vehicleId, int $id)
    {
        $model = Booking::find($id);
        $model->driver_id = $driverId;
        $model->vehicle_id = $vehicleId;
        return $model->update();
    }

    static public function findDriverCurrentBooking(int $driverId)
    {
        return Booking::whereHas('driver', function ($query) use ($driverId) {
                    $query->where('user_id', $driverId);
                })
                ->whereIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])
                ->with(['bookingStops','driver'])
                ->first();
    }

    static public function findCurrentBooking(int $userId)
    {
        return Booking::where('customer_id',$userId)
                ->whereIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])
                ->with(['bookingStops'])
                ->first();
    }

    static public function updateBookingStatus(string $status,int $id)
    {
        $model = Booking::find($id);
        $model->status = $status;
        $model->update();
        return $model;
    }
    public function update(Booking $booking,array $data)
    {

    }
}