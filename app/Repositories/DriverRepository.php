<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Models\Driver;
use App\Interfaces\IDriverRepository;
use Carbon\Carbon;

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

    public function getDriverIncome(int $id)
    {
        $driver = Driver::find($id);
        if(!$driver)
            return null;
        $booking = $driver->booking();
        $totalIncome = $booking->sum('pre_calculated_fare');//->sum('total_fare');
        $totalBookings = $booking->count();
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();
        $cardIncome =  Driver::find($id)->booking()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->whereHas('bookingPayment', function ($query) {
                                    $query->whereHas('paymentMethod', function ($query) {
                                        $query->where('name', 'card');
                                    });
                                })
                                ->sum('pre_calculated_fare');
        $cashIncome =  Driver::find($id)->booking()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->whereHas('bookingPayment', function ($query) {
                            $query->whereHas('paymentMethod', function ($query) {
                                $query->where('name', 'cash');
                            });
                        })
                        ->sum('pre_calculated_fare');

        return [
            'totalIncome'=>$totalIncome,
            'totalBookings'=>$totalBookings,
            'thisWeek'=>[
                'cardIncome'=>$cardIncome,
                'cashIncome'=>$cashIncome,
                ]
        ];
    }
}
