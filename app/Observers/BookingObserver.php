<?php

namespace App\Observers;

use App\Constants\Constants;
use App\Events\DriverBooking;
use App\Jobs\SendFcmNotification;
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
                    event(new DriverBooking($driverVehicle->driver_id,$booking));
                    $notificationTitle = "New Ride Request";
                    $notificationMessage = "A new ride request is available nearby. Tap to accept and start the ride.";
                    dispatch(new SendFcmNotification($driverVehicle->driver->user->device_token, $notificationTitle, $notificationMessage));
                    return BookingRepository::assignDriver($driverVehicle->driver_id, $driverVehicle->vehicle_id, $booking->id);
                }
            }
        }
        return BookingRepository::updateBookingStatus('noDriverFound',$booking->id);
    }
}
