<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDriverStatusRequest;
use App\Interfaces\IDriverRepository;
use App\Interfaces\IUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    private IDriverRepository $driverRepository;

    private IUserRepository $userRepository;
    public function __construct(IDriverRepository $driverRepository, IUserRepository $userRepository)
    {
        $this->driverRepository = $driverRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Action for update driver status
     *
     * @return APIResponse
     */
    public function onlineStatus(UpdateDriverStatusRequest $request)
    {
        try
        {
            $driver =   $this->driverRepository->onlineStatus($request->isOnline, $request->id);
            if (!$driver)
                APIResponse::UnknownInternalServerError('Error while updating');
            return APIResponse::Success('Resource updated');
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }
}