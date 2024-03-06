<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Constants;
use App\Events\BookingStatus;
use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginatedRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingPaymentStatusRequest;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Http\Resources\BookingStopsResource;
use App\Http\Resources\BookingWithStopsResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\IBookingPaymentsRepository;
use App\Interfaces\IBookingRepository;
use App\Interfaces\IBookingStopsRepository;
use App\Jobs\SendFcmNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{


    public function __construct(
            private IBookingRepository $bookingRepository,
            private IBookingStopsRepository $bookingStopsRepository,
            private IBookingPaymentsRepository $BookingPaymentsRepository
            ){}

    /**
     * Action for store booking of logged-in user with multiple stops.
     *
     * @return APIResponse in json format
     */
    public function store(StoreBookingRequest $request)
    {
        try {

            $booking = $this->bookingRepository::create(['customer_id'=>Auth::user()->id,
                                                        'status'=>'waiting',
                                                        'type'=>Constants::BOOKING_TYPE_ON_DEMAND,
                                                        'pre_calculated_fare'=>$request->preCalculatedFare
                                                    ]);

            foreach($request['data'] as $bookingStop)
            {
                $bookingStop['booking_id'] = $booking->id;
                $bookingStop['status'] = Constants::BOOKING_STOP_STATUS_ACTIVE;
                $this->bookingStopsRepository::create($bookingStop);
            }
            $this->bookingRepository->createBookingPayment($booking->id,$request->paymentMethodId);
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
     * Action for getting bookings for logged-in driver or user.
     *
     * @return APIResponse in json format
     */
    public function list(CommonPaginatedRequest $request)
    {
        try
        {
            if(Auth::user()->roles->first()->name == 'driver'){
                $booking = $this->bookingRepository::findDriverBookings($request->id)->paginate($request->perPage)->appends(['sort'=>$request->sortBy]);
            }else{
                $booking = $this->bookingRepository::findCustomerBookings($request->id)->paginate($request->perPage)->appends(['sort'=>$request->sortBy]);
            }
            if(!$booking)
                return APIResponse::NotFound('No result found');
            $bookingWithStops = BookingWithStopsResource::collection($booking);
            $paginate = PaginateResource::make($bookingWithStops);
            return APIResponse::SuccessWithDataAndPagination('Success', $bookingWithStops, $paginate);

        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    /**
     * Action for getting bookings for logged-in driver or user.
     *
     * @return APIResponse in json format
     */
    public function get(Request $request)
    {
        try
        {
            $validator = Validator::make($request->route()->parameters(), [
                'id' => ['required','numeric'],
                'bookingId' => ['required','numeric','exists:bookings,id'],
            ]);
            if ($validator->fails())
                return APIResponse::BadRequest($validator->errors()->first());
            $booking = $this->bookingRepository::findBooking((int) $request->bookingId);
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
    public function bookingStatus(UpdateBookingStatusRequest $request)
    {
        try
        {
            $validator = Validator::make($request->route()->parameters(), [
                'id' => ['required','numeric'],
                'bookingId' => ['required','numeric','exists:bookings,id'],
            ]);
            if ($validator->fails())
                return APIResponse::BadRequest($validator->errors()->first());
            $bookingUpdated = $this->bookingRepository::updateBookingStatus($request->status, $request->bookingId);
            if (!$bookingUpdated)
                return APIResponse::NotFound('No result found');

            $notificationMessage = '';
            $notificationTitle = '';

            switch ($bookingUpdated->status) {
                case 'accepted':
                    $notificationTitle = "Ride Confirmed!";
                    $notificationMessage = "Your ride has been confirmed. {$bookingUpdated->driver->user->full_name} is on the way to pick you up. They will arrive shortly. Thank you for choosing our service.";
                    break;
                case 'inProgress':
                    $notificationTitle = "Your Ride Has Started!";
                    $notificationMessage = "Your ride has officially started with {$bookingUpdated->driver->user->full_name}. They are on the way to your location. Sit back, relax, and enjoy the journey!";
                    $this->bookingStopsRepository::addDriverPickUpCoordinates($request->driver['latitude'], $request->driver['longitude'], $bookingUpdated->id);
                    break;
                case 'completed':
                    $notificationTitle = "Ride Completed";
                    $notificationMessage = "Your ride has been successfully completed. Thank you for choosing our service! Please take a moment to rate your ride and provide any feedback. We value your input and look forward to serving you again.";
                    $this->bookingStopsRepository::addDriverdropOffCoordinates($request->driver['latitude'], $request->driver['longitude'], $bookingUpdated->id);
                    $bookingPayment = $this->BookingPaymentsRepository::create($bookingUpdated);
                    $bookingUpdated->refresh();
                    break;
            }

            // Dispatch the FCM notification
            if ($notificationMessage && $notificationTitle) {
                dispatch(new SendFcmNotification($bookingUpdated->customer->device_token, $notificationTitle, $notificationMessage));
            }

            event(new BookingStatus($request->bookingId, $request->status));
            $bookingWithStops = BookingWithStopsResource::make($bookingUpdated);
            return APIResponse::SuccessWithData('Success', $bookingWithStops);
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    /**
     * Action for updating booking payment status.
     *
     * @return APIResponse in json format
     */
    public function paymentStatus(UpdateBookingPaymentStatusRequest $request)
    {
        try
        {
            $validator = Validator::make($request->route()->parameters(), [
                'id' => ['required','numeric'],
                'bookingId' => ['required','numeric','exists:bookings,id'],
            ]);
            if ($validator->fails())
                return APIResponse::BadRequest($validator->errors()->first());
            $bookingUpdated = $this->bookingRepository::updateBookingPaymentStatus($request->status, $request->bookingId);
            if (!$bookingUpdated)
                return APIResponse::NotFound('No result found');
            $bookingWithStops = BookingWithStopsResource::make($bookingUpdated);
            return APIResponse::SuccessWithData('Success', $bookingWithStops);
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }
    /**
     * Action for current bookings for logged-in driver or user.
     *
     * @return APIResponse in json format
     */
    public function currentBooking(Request $request)
    {
        try
        {
            $validator = Validator::make($request->route()->parameters(), [
                'id' => ['required','numeric'],
            ]);
            if ($validator->fails())
                return APIResponse::BadRequest($validator->errors()->first());

            if(Auth::user()->roles->first()->name == 'driver'){
                $booking = $this->bookingRepository::findDriverActiveBookings($request->id);
            }else{
                $booking = $this->bookingRepository::findCustomerActiveBookings($request->id);
            }
            if(!$booking)
                return APIResponse::NotFound('No result found');
            $bookingWithStops = BookingWithStopsResource::make($booking);

            return APIResponse::SuccessWithData('Success', $bookingWithStops);

        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

}
