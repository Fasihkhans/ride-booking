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

    static public function update(VehicleType $vehicleType,array $data)
    {
        $vehicleType->name= $data['name'];
        $vehicleType->base_fare= $data['base_fare'];
        $vehicleType->per_minute_rate= $data['per_minute_rate'];
        $vehicleType->per_mile_rate= $data['per_mile_rate'];
        $vehicleType->min_mintues= $data['min_mintues'];
        $vehicleType->min_miles= $data['min_miles'];
        $vehicleType->holiday_rate= $data['holiday_rate'];
        $vehicleType->peak_hour_rate= $data['peak_hour_rate'];
        $vehicleType->night_base_fare= $data['night_base_fare'];
        $vehicleType->night_per_minute_rate= $data['night_per_minute_rate'];
        $vehicleType->night_per_mile_rate= $data['night_per_mile_rate'];
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

    /**
     * Fetch data from the VehicleType model based on a given name.
     *
     * @param int $id
     * @return object
     */
    static public function getVehicleByName(string $name)
    {
        return VehicleType::where('name',$name)->first();
    }
    static public function list()
    {
        return VehicleType::orderBy('created_at', 'desc');
    }
}
