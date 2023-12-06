<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListVehicleTypesRequest;
use App\Http\Resources\ListVehicleTypesResource;
use App\Http\Resources\PaginateResource;
use Illuminate\Http\Request;
use App\Interfaces\IVehicleTypesRepository;
use Exception;


class VehicleTypesController extends Controller
{
    private IVehicleTypesRepository $vehicleTypeRepository;

    public function __construct(IVehicleTypesRepository $vehicleTypesRepository)
    {
        $this->vehicleTypeRepository = $vehicleTypesRepository;
    }

    public function list(ListVehicleTypesRequest $request)
    {
        try{
            $perPage = $request->input('per_page', 10);
            $vehicleTypes = $this->vehicleTypeRepository::list()->paginate($perPage);
            if (!$vehicleTypes)
                    APIResponse::NotFound('No result found');
            $vehicleTypes = ListVehicleTypesResource::collection($vehicleTypes);
            $paginate = PaginateResource::make($vehicleTypes);
            return APIResponse::SuccessWithDataAndPagination('Success', $vehicleTypes, $paginate);
        }catch(Exception $ex){
            return APIResponse::InternalServerError($ex);
        }
    }
}