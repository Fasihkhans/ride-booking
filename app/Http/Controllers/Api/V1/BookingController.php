<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Constants;
use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingWithStopsResource;
use App\Interfaces\IBookingRepository;
use App\Interfaces\IBookingStopsRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private IBookingRepository $bookingRepository;

    private IBookingStopsRepository $bookingStopsRepository;

    public function __construct(IBookingRepository $bookingRepository, IBookingStopsRepository $bookingStopsRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->bookingStopsRepository = $bookingStopsRepository;
    }

    public function store(StoreBookingRequest $request)
    {
        try {

            $booking = $this->bookingRepository::create(['customer_id'=>Auth::user()->id,
                                                        'status'=>Constants::BOOKING_WAITING,
                                                        'type'=>Constants::BOOKING_TYPE_ON_DEMAND
                                                    ]);

            foreach($request['data'] as $bookingStop)
            {
                $bookingStop['booking_id'] = $booking->id;
                $bookingStop['status'] = Constants::BOOKING_STOP_STATUS_ACTIVE;
                $this->bookingStopsRepository::create($bookingStop);
            }
            $bookingWithStops = $this->bookingRepository::findWithStops($booking->id);
            if (!$bookingWithStops)
                APIResponse::NotFound('No result found');
            $bookingWithStops = BookingWithStopsResource::make($bookingWithStops);
            return APIResponse::SuccessWithData('Success', $bookingWithStops);

        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

}