<?php

namespace App\Http\Resources;

use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingStopsResource extends JsonResource
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
            'bookingId' => $this->booking_id,
            'stop' => $this->stop,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'sequenceNo' => $this->sequence_no,
            'status' => $this->transformStatus($this->status),
            'is_favourite' => (bool) $this->is_favourite ,
            'type' => $this->type,
            'locationObj' => $this->location_obj,
            'driverLatitude' => $this->driver_latitude,
            'driverLongitude' => $this->driver_longitude,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }

    private function transformStatus($status)
    {
        switch ($status) {
            case Constants::BOOKING_STOP_STATUS_ACTIVE:
                $value = 'active';
                break;
            default:
                $value = 'unknownStatus';
                break;
        }

        return $value;
    }
}
