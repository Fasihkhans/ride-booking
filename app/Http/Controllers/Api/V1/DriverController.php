<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDriverStatusRequest;
use App\Interfaces\IDriverRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    private IDriverRepository $iDriverRepository;

    public function __construct(IDriverRepository $iDriverRepository)
    {
        $this->iDriverRepository = $iDriverRepository;
    }

    /**
     * Action for update driver status
     *
     * @return APIResponse
     */
    public function updateStatus(UpdateDriverStatusRequest $request)
    {
        try
        {
            $driver =   $this->iDriverRepository::UpdateStatus($request->status,Auth::user()->id);
            if (!$driver)
                APIResponse::UnknownInternalServerError('Error while updating');
            return APIResponse::Success('Resource updated');
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }
}