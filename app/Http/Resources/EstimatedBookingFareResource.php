<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use App\Repositories\CustomerPaymentMethodsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TeamPickr\DistanceMatrix\DistanceMatrix as DistanceMatrixDistanceMatrix;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;

class EstimatedBookingFareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $booking = $this;
        // $bookingTime = $booking->created_at;
        // $dayStartTime = Carbon::createFromTime(6, 0, 0); // 06:00:00
        // $dayEndTime = Carbon::createFromTime(22, 0, 0);  // 22:00:00
        // if ($bookingTime->between($dayStartTime, $dayEndTime)) {
        //     $baseFare = $booking?->vehicle?->vehicleType?->base_fare;
        // } else {
        //     $baseFare = $booking?->vehicle?->vehicleType?->base_fare;
        // }
        // dd($baseFare);
        // $perMinuteRate = $booking?->vehicle?->vehicleType?->per_minute_rate;
        // $perMileRate = $booking?->vehicle?->vehicleType?->per_mile_rate;
        // $peakHourRate = $booking?->vehicle?->vehicleType?->peak_hour_rate;
        // $holidayRate = $booking?->vehicle?->vehicleType?->holiday_rate;
        // $paymentMethodId = $booking->customer->customerPaymentMethods->first()?->id??CustomerPaymentMethodsRepository::create(['user_id'=>$booking->customer->id,'name' => "cash",'status' => Constants::ACTIVE])->id;
        // $startTime = null;
        // $endTime = null;
        // $origins ='';
        // $destinations = '';
        // foreach($booking?->bookingStops as $stop)
        // {
        //     if($stop->type =='pickUp'){
        //         $origins .= $stop?->driver_latitude.",".$stop?->driver_longitude; // ctemp============>
        //         $startTime = $stop?->created_at;
        //     }
        //     if($stop->type =='middleStop'){
        //         $origins .= "|".$stop?->latitude.",".$stop?->longitude;
        //         $destinations .= $stop?->latitude.",".$stop?->longitude.'|';
        //     }

        //     if($stop->type =='dropOff'){
        //         $destinations .= $stop?->latitude.",".$stop?->longitude;
        //         $endTime = $stop?->created_at;
        //     }
        // }
        // $totalMinutes = $startTime?->diffInMinutes($endTime)?? 0;

        // $license = new StandardLicense(env('GOOGLE_MAPS_KEY'));
        // $getDistance = DistanceMatrixDistanceMatrix::license($license)
        //                 ->addOrigin($origins)
        //                 ->addDestination($destinations)->useMetricUnits()
        //                 ->request();

        // $totalMeters = 0;
        // $count = 0;
        // foreach($getDistance->rows() as $distance)
        // {
        //     $totalMeters += $distance->elements()[$count]->distance();
        //     $count++;
        // }
        // $totalMiles = round($totalMeters*0.00062137,1);
        // $totalCost = $baseFare + ($perMinuteRate * $totalMinutes)+($perMileRate * $totalMiles);

        return [
            'booking_id' => null,//$booking->id,
            'baseFare' => null,//$baseFare,
            'perMileRate' => null,//$perMileRate,
            'perMinuteRate' => null,//$perMinuteRate,
            'peakHourRate' => null,//$peakHourRate,
            'holidayRate' => null,//$holidayRate,
            'totalMinutes' => 0,//$totalMinutes,
            'totalMiles' => 0,//$totalMiles,
            'totalFare' => 0,//$totalCost,
        ];
    }
}