<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            "userId" => $this->user_id,
            "name" => $this->name,
            "stripeCardReference" => $this->stripe_card_reference,
            "isDefault" => $this->is_default,
            "status" => $this->status,
            "createdAt"=> $this->created_at,
            "updatedAt"=> $this->updated_at
        ];
    }
}