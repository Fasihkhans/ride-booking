<?php

namespace App\Repositories;

use App\Models\Vehicles;
use App\Interfaces\IVehiclesRepository;

class VehiclesRepository implements IVehiclesRepository
{
    static public function create(array $data)
    {
        return Vehicles::create($data);
    }

    public function update(Vehicles $Vehicles,array $data)
    {
        $Vehicles->name = $data['name'];
        $Vehicles->fare = $data['fare'];
        $Vehicles->upload_url = $data['upload_url'];
        return $Vehicles->save();
    }
}