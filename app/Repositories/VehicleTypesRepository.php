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

    /**
     * Fetch data from the VehicleType model based on a search query.
     *
     * @param string|null $search
     * @return
     */
    public static function fetchData(string $search = null)
    {
        $query = VehicleType::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        return $query;
    }

    static public function fetchPaginateData(string $search, int $perPage = 10)
    {
        // return self::fetchData($search)->paginate($perPage);
        return VehicleType::paginate($perPage);
    }

    /**
     * Fetch data from the VehicleType model based on a given id.
     *
     * @param int $id
     * @return object
     */
    static public function findById(int $id)
    {
        return VehicleType::find($id);
    }
    static public function list()
    {
        return VehicleType::orderBy('created_at', 'desc');
    }
}