<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Constants;
use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginatedRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Http\Resources\BookingStopsResource;
use App\Http\Resources\BookingWithStopsResource;
use App\Http\Resources\PaginateResource;
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

    /**
     * Action for store booking of logged-in user with multiple stops.
     *
     * @return APIResponse in json format
     */
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

    /**
     * Action for getting latest stops for logged-in user.
     *
     * @return APIResponse in json format
     */
    public function latestStops(CommonPaginatedRequest $request)
    {
        try {
            $latestStops = $this->bookingStopsRepository::findLatestStops(Auth::user()->id)->paginate($request->perPage)->appends(['sort'=>$request->sortBy]);
            if (!$latestStops)
                APIResponse::NotFound('No result found');
            $latestStops = BookingStopsResource::collection($latestStops);
            $paginate = PaginateResource::make($latestStops);
            return APIResponse::SuccessWithDataAndPagination('Success', $latestStops, $paginate);


        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

    /**
     * Action for update is favourite stops for logged-in user.
     *
     * @return APIResponse in json format
     */
    public function favouriteStop(Request $request)
    {
        try {
            $updatedStop = $this->bookingStopsRepository::updateIsFav($request->isFavourite,$request->id);
            if (!$updatedStop)
                APIResponse::UnknownInternalServerError('Error while updating');
            return APIResponse::Success('Resource updated');
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    /**
     * Action for getting current booking for logged-in driver or user.
     *
     * @return APIResponse in json format
     */
    public function currentBooking()
    {
        try
        {
            if(Auth::guard('driver')->check()){
                $booking = $this->bookingRepository::findDriverCurrentBooking(Auth::user()->id);
            }else{
                $booking = $this->bookingRepository::findCurrentBooking(Auth::user()->id);
            }
            if(!$booking)
                return APIResponse::NotFound('No result found');
            $bookingWithStops = BookingWithStopsResource::make($booking);
            return APIResponse::SuccessWithData('Success', $bookingWithStops);
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    /**
     * Action for updating booking status for logged-in drivers or users.
     *
     * @return APIResponse in json format
     */
    public function currentBookingStatus(UpdateBookingStatusRequest $request)
    {
        try
        {
            if (Auth::guard('driver')->check()) {
                $booking = $this->bookingRepository::findDriverCurrentBooking(Auth::user()->id);
            } else {
                $booking = $this->bookingRepository::findCurrentBooking(Auth::user()->id);
            }

            if (!$booking)
                return APIResponse::NotFound('No result found');

            $bookingUpdated = $this->bookingRepository::updateBookingStatus($request->status, $booking->id);

            if (!$bookingUpdated)
                return APIResponse::NotFound('No result found');

            $bookingWithStops = BookingWithStopsResource::make($bookingUpdated);
            return APIResponse::SuccessWithData('Success', $bookingWithStops);
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }
}