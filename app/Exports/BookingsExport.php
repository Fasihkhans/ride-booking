<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Booking::select([
            'vehicles.license_no_plate',
            'users.first_name',
            'bookings.pre_calculated_fare',
            'bookings.type',
            'bookings.status',
        ])
        ->orderBy('bookings.created_at', 'desc')
        ->join('drivers', 'bookings.driver_id', '=', 'drivers.id')
        ->join('users', 'drivers.user_id', '=', 'users.id')
        ->join('vehicles', 'bookings.vehicle_id', '=', 'vehicles.id')
        ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Number',
            'Driver',
            'Est Amount',
            'type',
            'Status'
        ];
    }
}