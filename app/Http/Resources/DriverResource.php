<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DriverResource extends JsonResource
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
            'userId'=> $this->user_id,
            'licenseNo'=> $this->license_no,
            'licenseExpiry'=> $this->license_expiry,
            'licenseImgUrl' =>Storage::disk(env('CURRENT_IMG_DRIVER'))->exists($this->license_img_url)? Storage::disk(env('CURRENT_IMG_DRIVER'))->url($this->license_img_url) : Storage::disk(env('CURRENT_IMG_DRIVER'))->url($this->license_img_url),
            'isOnline' => $this->is_online,
            'createdAt'=> $this->created_at,
            'updatedAt'=> $this->updated_at,
            'user' => DriverUserResource::make($this->user)
        ];
    }
}
