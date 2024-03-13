<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRatingRequest;
use App\Http\Resources\UserRatingResource;
use App\Interfaces\IUserRatingRepository;
use App\Interfaces\IUserRepository;
use App\Models\UserRating;
use Exception;
use Illuminate\Http\Request;

class UserRatingController extends Controller
{

    public function __construct(private IUserRatingRepository $iUserRatingRepository,private IUserRepository $iUserRepository)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRatingRequest $request)
    {
        try {
            $method = $this->iUserRatingRepository->create($request->all());
            if(!$method)
                return APIResponse::Fail('Something went wrong.');
            $method = UserRatingResource::make($method);
            $avgRating = $this->iUserRatingRepository->getUserAverageRating($request->userId);
            $this->iUserRepository->updateAggregateRating($avgRating,$request->userId);
            return APIResponse::SuccessWithData('Success',$method);

        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRating $userRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRating $userRating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRating $userRating)
    {
        //
    }
}
