<?php

namespace App\Observers;

use App\Constants\Constants;
use App\Models\Booking;
use App\Repositories\BookingRepository;
use App\Repositories\DriverRepository;
use App\Repositories\DriverVehiclesRepository;

class BookingObserver
{
    public function created(Booking $booking)
    {
        $driverVehicles = DriverVehiclesRepository::getActive();
        $bookingFound = false;
        foreach($driverVehicles as $driverVehicle){
            //discuss it for performance
            $result = BookingRepository::findDriverForBooking($driverVehicle->vehicle_id,$driverVehicle->driver_id);
            if ($result == null) {
                if(DriverRepository::isOnline($driverVehicle->driver_id)){
                    return BookingRepository::assignDriver($driverVehicles[0]->driver_id, $driverVehicles[0]->vehicle_id, $booking->id);
                }
            }
        }
        return BookingRepository::updateBookingStatus('noDriverFound',$booking->id);
    }
}