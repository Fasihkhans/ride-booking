<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Constants;
use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginatedRequest;
use App\Http\Requests\IsDefaultRequest;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UserIdRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\PaymentMethodResource;
use App\Interfaces\ICustomerPaymentMethodsRepository;
use Exception;
use Illuminate\Http\Request;
use Stripe\ApiResponse as StripeApiResponse;

class PaymentController extends Controller
{

    public function __construct(private ICustomerPaymentMethodsRepository $iCustomerPaymentMethodsRepository){}
    public function store(StorePaymentMethodRequest $request,UserIdRequest $userIdRequest)
    {
        try {
            $method = $this->iCustomerPaymentMethodsRepository::create([
                'user_id'=>$userIdRequest->id,
                'name' => "card",
                'stripe_card_reference' => $request->stripeCardReference,
                'is_default'=>false,
                'status' => Constants::ACTIVE
            ]);
            if(!$method)
                return APIResponse::Fail('Something went wrong.');
            $method = PaymentMethodResource::make($method);
            return APIResponse::SuccessWithData('Success',$method);
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }

    }

    public function list(CommonPaginatedRequest $request,UserIdRequest $userIdRequest)
    {
        try {
            $method = $this->iCustomerPaymentMethodsRepository->getWhere('user_id',$userIdRequest->id)
                        ?->paginate($request->perPage);
            if(!$method)
                return APIResponse::NotFound('No record found');
            $method = PaymentMethodResource::collection($method);
            $paginate = PaginateResource::make($method);
            return APIResponse::SuccessWithDataAndPagination('Success',$method,$paginate);
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    public function destory(UserIdRequest $request)
    {
        try {
            $method = $this->iCustomerPaymentMethodsRepository->destroy($request->methodId);
            if(!$method)
                return APIResponse::Fail('Something went wrong.');
            return APIResponse::Success('Success');
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }

    public function default(IsDefaultRequest $request,UserIdRequest $userIdRequest)
    {
        try {
            $method = $this->iCustomerPaymentMethodsRepository->IsDefault($userIdRequest->methodId,$request->isDefault);
            if(!$method)
                return APIResponse::Fail('Something went wrong.');
            $method = PaymentMethodResource::make($method);
            return APIResponse::SuccessWithData('Success',$method);

        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }
}