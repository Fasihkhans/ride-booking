<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListVehicleTypesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "typeName" => $this->name,
            "typeImg" => $this->upload_url,
            "baseFare" => $this->base_fare,
            "perMinuteRate" => $this->per_minute_rate,
            "perMileRate" => $this->per_mile_rate,
            "minMiles" => $this->min_miles,
            "minMinutes" => $this->min_minutes,
            "holidayRate" => $this->hoilday_rate,
            "pearHourRate" => $this->peak_hour_rate,
            "nightBaseFare" => $this->night_base_fare,
            "nightPerMinuteRate" => $this->night_per_minute_rate,
            "nightPerMileRate" => $this->night_per_mile_rate,
        ];
    }
}
