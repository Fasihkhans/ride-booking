<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Models\Vehicles;
use App\Interfaces\IVehiclesRepository;

class VehiclesRepository implements IVehiclesRepository
{
    static public function create(array $data)
    {
        return Vehicles::create($data);
    }

    static public function getAllActiveVehicles(){
        return Vehicles::where('status', Constants::ACTIVE_VEHICLE)->get();
    }

    static public function getAllVehicles(){
        return Vehicles::all();
    }

    static public function getVehicle(int $id)
    {
        return Vehicles::find($id);
    }
    static public function update(Vehicles $Vehicles,array $data)
    {
        $Vehicles->make = $data['make'];
        $Vehicles->model = $data['model'];
        $Vehicles->year = $data['year'];
        $Vehicles->license_no_plate = $data['license_no_plate'];
        $Vehicles->color = $data['color'];
        $Vehicles->max_capacity = $data['max_capacity'];
        $Vehicles->vehicle_type_id = $data['vehicle_type_id'];
        $Vehicles->status =  $data['status'];
        return $Vehicles->save();
    }
}