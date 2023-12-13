<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Models\Driver;
use App\Interfaces\IDriverRepository;

class DriverRepository implements IDriverRepository
{
    static public function create(array $data)
    {
        return Driver::create($data);
    }

    static public function getAllActiveDrivers()
    {
        return Driver::whereHas('user', function ($query) {
            $query->whereIn('status', [Constants::ACTIVE_DRIVER,Constants::ACTIVE_DRIVER_ON_BREAK]);
        })->with('user')->get();
    }

    static public function updateStatus(string $status, int $id)
    {
        $model = Driver::find($id);
        $model->status = $status;
        $model->update();
        return $model;
    }
    public function update(Driver $driver,array $data)
    {
        $driver->license_no = $data['license_no'];
        $driver->license_expiry = $data['license_expiry'];
        return $driver->save();
    }
}
