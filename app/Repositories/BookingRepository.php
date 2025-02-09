<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Models\Booking;
use App\Interfaces\IBookingRepository;
use App\Models\BookingPayments;
use Illuminate\Support\Facades\DB;

class BookingRepository implements IBookingRepository
{
    static public function create(array $data)
    {
        return Booking::create($data);
    }

    static public function find(int $id)
    {
        return Booking::find($id);
    }

    static public function findWithStops(int $id)
    {
        return Booking::with('bookingStops')->find($id);
    }
    static public function findDriverForBooking(int $vehicleId,int $driverId)
    {
        return Booking::where(['vehicle_id'=>$vehicleId,'driver_id'=>$driverId])
                ->whereIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])
                ->with('driver')
                ->first();
    }

    static public function updateStatus(int $status,int $id)
    {
        $model = Booking::find($id);
        $model->status = $status;
        return $model->update();
    }

    static public function assignDriver(int $driverId,int $vehicleId, int $id)
    {
        $model = Booking::find($id);
        $model->driver_id = $driverId;
        $model->vehicle_id = $vehicleId;
        return $model->update();
    }

    static public function findDriverBookings(int $driverId)
    {
        return Booking::where('driver_id',$driverId)
                ->with(['bookingStops','driver','vehicle'])
                ->orderBy('updated_at', 'desc');
    }
    static public function findCustomerBookings(int $userId)
    {
        return Booking::where('customer_id',$userId)
                ->with(['bookingStops','driver','vehicle'])
                ->orderBy('updated_at', 'desc');
    }

    static public function findBooking(int $id)
    {
        return Booking::where('id',$id)
                ->with(['bookingStops','driver','vehicle'])
                ->first();
    }

    static public function findDriverActiveBookings(int $driverId)
    {
        return Booking::where('driver_id',$driverId)
                ->whereIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])
                ->with(['bookingStops','driver','vehicle'])
                ->orderBy('updated_at', 'desc')
                ->first();
    }

    static public function findCustomerActiveBookings(int $userId)
    {
        return Booking::where('customer_id',$userId)
                ->whereIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])
                ->WhereNotNull('driver_id')
                ->with(['bookingStops','driver','vehicle'])
                ->orderBy('updated_at', 'desc')
                ->first();
    }


    static public function updateBookingStatus(string $status,int $id)
    {
        $model = Booking::find($id);
        $model->status = $status;
        $model->update();
        return $model;
    }
    static public function updateBookingPaymentStatus(string $status, int $id)
    {
        $model = Booking::find($id);
        if($model->bookingPayment){
            $model->bookingPayment->status = $status;
            $model->update();
            return $model;

        }
        return null;
    }


    static public function getActiveBookings()
    {
        return Booking::whereIn('status',[Constants::BOOKING_WAITING, Constants::BOOKING_ACCEPTED,Constants::BOOKING_IN_PROGRESS])->get();
    }

    static public function getCompletedBookings()
    {
        return Booking::where('status',Constants::BOOKING_COMPLETED)->get();
    }

    static public function getCompletedBookingsWithDateRange($startDate,$endDate)
    {
        return Booking::where('status',Constants::BOOKING_COMPLETED)->whereBetween('created_at', [$startDate, $endDate])->get();
    }

    static public function getAllBookingDateWise($date)
    {
        return Booking::where('created_at','>=', $date)->get();
    }

    public function createBookingPayment(int $bookingId, int $paymentMethodId)
    {
        return BookingPayments::create([
            'booking_id'=>$bookingId,
            'payment_method_id'=>$paymentMethodId,
            'status' => Constants::BOOKING_PAYMENT_PENDING
        ]);
    }

    public function update(Booking $booking,array $data)
    {

    }
}
