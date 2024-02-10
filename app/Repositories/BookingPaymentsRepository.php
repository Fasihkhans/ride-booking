<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Helpers\APIResponse;
use App\Interfaces\IBookingPaymentsRepository;
use App\Models\Booking;
use App\Models\BookingPayments;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Stripe;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;
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
        // $paymentMethodId = $booking->customer->customerPaymentMethods->first()?->id??CustomerPaymentMethodsRepository::create(['user_id'=>$booking->customer->id,'name' => "cash",'status' => Constants::ACTIVE])->id;
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
        $bookingPayment = BookingPayments::find($booking->bookingPayment->id);

        if($bookingPayment->paymentMethod->name =='card'){
            $card = json_decode($bookingPayment->paymentMethod->stripe_card_reference);
            // dd($card);
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge = Charge::create([
                'amount' => $totalCost * 100, // Stripe requires amount in cents
                'currency' => 'gbp',
                'customer' => $booking->customer_id,
                'source' => $card->token->card->id,
                'description' => 'Payment for booking id: ' . $booking->id,
            ]);
            // Check if charge was successful
            if ($charge->status === 'succeeded') {
                $bookingPayment->status = Constants::BOOKING_PAYMENT_PAID;
            } else {
                $bookingPayment->status = Constants::BOOKING_PAYMENT_FAILED;
            }

        }else{
            $bookingPayment->status = Constants::BOOKING_PAYMENT_PENDING;
        }
        $bookingPayment->booking_id = $booking->id;
        $bookingPayment->base_fare = $baseFare;
        $bookingPayment->per_mile_rate = $perMileRate;
        $bookingPayment->per_minute_rate = $perMinuteRate;
        $bookingPayment->peak_hour_rate = $peakHourRate;
        $bookingPayment->holiday_rate = $holidayRate;
        $bookingPayment->total_minutes = $totalMinutes;
        $bookingPayment->total_miles = $totalMiles;
        $bookingPayment->total_fare = $totalCost;


        return $bookingPayment->update();
    }

}
