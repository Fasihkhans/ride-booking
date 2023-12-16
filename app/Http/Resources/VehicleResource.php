<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'vehicleTypeId'=> $this->vehicle_type_id,
            'licenseNoPlate'=> $this->license_no_plate,
            'make'=> $this->make,
            'model'=> $this->model,
            'year'=> $this->year,
            'color'=> $this->color,
            'maxCapacity'=> $this->max_capacity,
            'status'=> $this->status,
            'createdAt'=> $this->created_at,
            'updatedAt'=> $this->updated_at,
        ];
    }
}
