<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Interfaces\IBookingPaymentsRepository;
use App\Models\Booking;
use App\Models\BookingPayments;
use Carbon\Carbon;
use TeamPickr\DistanceMatrix\DistanceMatrix as DistanceMatrixDistanceMatrix;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;

class BookingPaymentsRepository implements IBookingPaymentsRepository
{
    static public function create(Booking $booking)
    {

        $bookingTime = $booking->created_at;
        $dayStartTime = Carbon::createFromTime(6, 0, 0); // 06:00:00
        $dayEndTime = Carbon::createFromTime(22, 0, 0);  // 22:00:00
        if ($bookingTime->between($dayStartTime, $dayEndTime)) {
            $baseFare = $booking?->vehicle?->vehicleType?->base_fare;
        } else {
            $baseFare = $booking?->vehicle?->vehicleType?->night_base_fare;
        }
        $perMinuteRate = $booking?->vehicle?->vehicleType?->per_minute_rate;
        $perMileRate = $booking?->vehicle?->vehicleType?->per_mile_rate;
        $peakHourRate = $booking?->vehicle?->vehicleType?->peak_hour_rate;
        $holidayRate = $booking?->vehicle?->vehicleType?->holiday_rate;
        $paymentMethodId = $booking->customer->customerPaymentMethods->first()?->id??CustomerPaymentMethodsRepository::create(['user_id'=>$booking->customer->id,'name' => "cash",'status' => Constants::ACTIVE])->id;
        $startTime = null;
        $endTime = null;
        $origins ='';
        $destinations = '';
        foreach($booking?->bookingStops as $stop)
        {
            if($stop->type =='pickUp'){
                $origins .= $stop?->latitude.",".$stop?->longitude; // ctemp============>
                $startTime = $stop?->updated_at;
            }
            if($stop->type =='middleStop'){
                $origins .= "|".$stop?->latitude.",".$stop?->longitude;
                $destinations .= $stop?->latitude.",".$stop?->longitude.'|';
            }

            if($stop->type =='dropOff'){
                $destinations .= $stop?->latitude.",".$stop?->longitude;
                $endTime = $stop?->updated_at;
            }
        }
        $totalMinutes = $startTime?->diffInMinutes($endTime)?? 0;

        $license = new StandardLicense(env('GOOGLE_MAPS_KEY'));
        $getDistance = DistanceMatrixDistanceMatrix::license($license)
                        ->addOrigin($origins)
                        ->addDestination($destinations)->useMetricUnits()
                        ->request();
        // dd($origins);
        $totalMeters = 0;
        $count = 0;
        foreach($getDistance->rows() as $distance)
        {
            $totalMeters += $distance->elements()[$count]->distance();
            $count++;
        }
        $totalMiles = round($totalMeters*0.00062137,1);
        // dd($baseFare +($perMinuteRate * $totalMinutes)+($perMileRate * $totalMiles));
        $totalCost = $baseFare + ($perMinuteRate * $totalMinutes)+($perMileRate * $totalMiles);

        return BookingPayments::create([
            'booking_id' => $booking->id,
            'base_fare' => $baseFare,
            'per_mile_rate' => $perMileRate,
            'per_minute_rate' => $perMinuteRate,
            'payment_method_id' => $paymentMethodId,
            'status' => Constants::BOOKING_PAYMENT_PENDING,
            'peak_hour_rate' => $peakHourRate,
            'holiday_rate' => $holidayRate,
            'total_minutes' => $totalMinutes,
            'total_miles' => $totalMiles,
            'total_fare' => $totalCost,
        ]);
    }

}