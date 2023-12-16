<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class LoggedInUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $roleName = Role::find($this->role_id)->name;

        $response = [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'status' => $this->status == 1 ? "active" : "inactive",
            'userRole' => $roleName,
            'token' => $this->secret,
        ];

        if ($roleName == 'driver') {
            $response['driverDetails'] = DriverResource::make($this->driverDetails);
        }

        return $response;
    }
}