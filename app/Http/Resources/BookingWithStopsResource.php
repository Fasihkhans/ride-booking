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
            'status' => $this->transformStatus($this->status),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'type' => $this->type,
            'bookingStops' => BookingStopsResource::collection($this->bookingStops),
        ];
    }

    private function transformStatus($status)
    {
        switch ($status) {
            case Constants::BOOKING_WAITING:
                $value = 'waiting';
                break;

            case Constants::BOOKING_ACCEPTED:
                $value = 'accepted';
                break;

            case Constants::BOOKING_DECLINED:
                $value = 'declined';
                break;

            case Constants::BOOKING_COMPLETED:
                $value = 'completed';
                break;

            case Constants::BOOKING_IN_PROGRESS:
                $value = 'inProgress';
                break;
            default:
                $value = 'unknownStatus';
                break;
        }

        return $value;
    }
}