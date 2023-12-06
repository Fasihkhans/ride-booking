<?php

namespace App\Repositories;

use App\Models\VehicleType;
use App\Interfaces\IVehicleTypesRepository;
use Illuminate\Support\Facades\DB;

class VehicleTypesRepository implements IVehicleTypesRepository
{
    static public function create(array $data)
    {
        return VehicleType::create($data);
    }

    public function update(VehicleType $vehicleType,array $data)
    {
        $vehicleType->name = $data['name'];
        $vehicleType->fare = $data['fare'];
        $vehicleType->upload_url = $data['upload_url'];
        return $vehicleType->save();
    }

    static public function getAll()
    {
        return VehicleType::all();
    }

    static public function list()
    {
        return VehicleType::orderBy('created_at', 'desc');
    }
}