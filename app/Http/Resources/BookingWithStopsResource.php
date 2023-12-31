<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingWithStopsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customerId' => $this->customer_id,
            'driverId' => $this->driver_id,
            'vehicleId' => $this->vehicle_id,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'type' => $this->type,
            'estimatedFare' => EstimatedBookingFareResource::make($this),
            'bookingStops' => BookingStopsResource::collection($this->bookingStops),
            'customer' => CustomerDetailsResource::make($this->customer),
            'driver' =>  DriverResource::make($this->driver),
            'vehicle' => VehicleResource::make($this->vehicle),
            'paymentDetails' => PaymentDetailsResource::make($this->bookingPayment)
        ];
    }
}