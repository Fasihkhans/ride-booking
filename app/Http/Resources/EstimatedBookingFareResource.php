<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use App\Repositories\CustomerPaymentMethodsRepository;
use App\Repositories\VehicleTypesRepository;
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
        $booking = $this;
        $bookingTime = $booking->created_at;
        $vehicleType = $booking->vehicle->vehicleType?? VehicleTypesRepository::getVehicleByName('saloon');
        $dayStartTime = Carbon::createFromTime(6, 0, 0); // 06:00:00
        $dayEndTime = Carbon::createFromTime(22, 0, 0);  // 22:00:00
        if ($bookingTime->between($dayStartTime, $dayEndTime)) {
            $baseFare = $vehicleType?->base_fare;
        } else {
            $baseFare = $vehicleType?->night_base_fare;
        }
        // dd($baseFare);
        $perMinuteRate = $vehicleType?->per_minute_rate;
        $perMileRate = $vehicleType?->per_mile_rate;
        $peakHourRate = $vehicleType?->peak_hour_rate;
        $holidayRate = $vehicleType?->holiday_rate;
        $paymentMethodId = $booking->customer->customerPaymentMethods->first()?->id??CustomerPaymentMethodsRepository::create(['user_id'=>$booking->customer->id,'name' => "cash",'status' => Constants::ACTIVE])->id;
        $startTime = null;
        $endTime = null;
        $origins ='';
        $destinations = '';
        foreach($booking?->bookingStops as $stop)
        {
            if($stop->type =='pickUp'){
                $origins .= $stop?->latitude.",".$stop?->longitude; // ctemp============>
                $startTime = $stop?->created_at;
            }
            if($stop->type =='middleStop'){
                $origins .= "|".$stop?->latitude.",".$stop?->longitude;
                $destinations .= $stop?->latitude.",".$stop?->longitude.'|';
            }

            if($stop->type =='dropOff'){
                $destinations .= $stop?->latitude.",".$stop?->longitude;
                $endTime = $stop?->created_at;
            }
        }
        $totalMinutes = $startTime?->diffInMinutes($endTime)?? 0;

        $license = new StandardLicense(env('GOOGLE_MAPS_KEY'));
        $getDistance = DistanceMatrixDistanceMatrix::license($license)
                        ->addOrigin($origins)
                        ->addDestination($destinations)->useMetricUnits()
                        ->request();
        // dd($getDistance);
        $totalMeters = 0;
        $count = 0;
        foreach($getDistance->rows() as $distance)
        {
            $totalMeters += $distance->elements()[$count]->distance();
            $count++;
        }
        $totalMiles = round($totalMeters*0.00062137,1);
        $totalCost = $baseFare + ($perMinuteRate * $totalMinutes)+($perMileRate * $totalMiles);

        return [
            'booking_id' => $booking->id,
            'baseFare' => $baseFare,
            'perMileRate' => $perMileRate,
            'perMinuteRate' => $perMinuteRate,
            'peakHourRate' => $peakHourRate,
            'holidayRate' => $holidayRate,
            'totalMinutes' => $totalMinutes,
            'totalMiles' => $totalMiles,
            'totalFare' => (int) $booking->pre_calculated_fare,
        ];
    }
}
