<?php

namespace App\Observers;

use App\Constants\Constants;
use App\Models\Booking;
use App\Repositories\BookingRepository;
use App\Repositories\DriverVehiclesRepository;

class BookingObserver
{
    public function created(Booking $booking)
    {
        $driverVehicles = DriverVehiclesRepository::getActive();
        foreach($driverVehicles as $driverVehicle){
            //discuss it for performance
            $result = BookingRepository::findDriverForBooking($driverVehicle->vehicle_id,$driverVehicle->driver_id);
            if($result){
                return BookingRepository::assignDriver($driverVehicle->driver_id,$driverVehicle->vehicle_id,$booking->id);
            }
        }
        return BookingRepository::updateBookingStatus('noDriverFound',$booking->id);
    }
}