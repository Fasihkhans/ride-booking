<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "bookingId"=> $this->booking_id,
            "baseFare"=> $this->base_fare,
            "perMileRate"=> $this->per_mile_rate,
            "paymentMethodId"=> $this->payment_method_id,
            "status"=> $this->status,
            "perMinuteRate"=> $this->per_minute_rate,
            "peakHourRate"=> $this->peak_hour_rate,
            "holidayRate"=> $this->holiday_rate,
            "totalMinutes"=> $this->total_minutes,
            "totalMiles"=> $this->total_miles,
            "totalFare"=> $this->total_fare,
            "createdAt"=> $this->created_at,
            "updatedAt"=> $this->updated_at,
            ];
        }
}
