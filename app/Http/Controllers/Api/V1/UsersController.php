<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserIdRequest;
use App\Interfaces\IUserRepository;
use App\Jobs\SendMail;
use App\Mail\DeleteUserAccountMail;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct(
        private IUserRepository $iUserRepository
    ){}

    public function destroy(UserIdRequest $request)
    {
        try
        {
            $user = $this->iUserRepository->getById($request->id);
            $userDelete =   $this->iUserRepository->destory($request->id);
            if (!$userDelete)
                APIResponse::UnknownInternalServerError('Error while updating');
            SendMail::dispatch($user->email,new DeleteUserAccountMail());
            // $this->iUserRepository->logout($request->user(), true);
            return APIResponse::Success('Resource updated');
        } catch (Exception $ex) {
            return APIResponse::UnknownInternalServerError($ex);
        }
    }
}
