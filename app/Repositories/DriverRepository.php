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
            $query->whereIn('status', [Constants::ACTIVE,Constants::INACTIVE]);
        })->with('user')->get();
    }

    static public function findByUserID(int $userId)
    {
        return Driver::where('user_id', $userId)->first();
    }

    static public function findByIdWithUser(int $id)
    {
        return Driver::where('id',$id)->with('user');
    }
    static public function onlineStatus(bool $status, int $id)
    {
        $model = Driver::find($id);
        $model->is_online = $status;
        $model->update();
        return $model;
    }

    static public function isOnline(int $id)
    {
        return Driver::where('id', $id)->value('is_online');
    }
    public function update(Driver $driver,array $data)
    {
        $driver->license_no = $data['license_no'];
        $driver->license_expiry = $data['license_expiry'];
        return $driver->save();
    }

    static public function updateDriver(int $id,array $data)
    {
        $driver = Driver::find($id);
        $driver->license_no = $data['license_no'];
        $driver->license_expiry = $data['license_expiry'];
        $driver->license_img_url = $data['license_img_url'];
        return $driver->save();
    }
}