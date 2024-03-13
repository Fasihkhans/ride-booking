<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rating'=>$this->rating,
            'review'=> $this->review,
            'user'=> CustomerDetailsResource::make($this->user),
            'booking'=> BookingWithStopsResource::make($this->booking),
        ];
    }
}
