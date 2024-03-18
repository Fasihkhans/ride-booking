<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRecoveryRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\VerificationCodeRequest;
use App\Interfaces\IUserRepository;
use App\Interfaces\IVerificationCodeRepository;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class AccountRecoveryController extends Controller
{
    private IUserRepository $userRepository;
    private IVerificationCodeRepository $verificationCodeRepository;

    public function __construct(IUserRepository $userRepository, IVerificationCodeRepository $verificationCodeRepository)
    {
        $this->userRepository = $userRepository;
        $this->verificationCodeRepository = $verificationCodeRepository;
    }

    public function forgot(VerificationCodeRequest $request)
    {
        try {
            $user = $this->userRepository->getWhere('email', $request->email);
            if (!$this->verificationCodeRepository->canGenerate($user->id, $request->verification_purpose_id))
                return APIResponse::TooManyRequests('Too many requests. Please try later');
            $verificationCode = $this->verificationCodeRepository->generate($user->id, $request->verification_purpose_id);
            if (!$verificationCode)
                return APIResponse::UnknownInternalServerError('Could not sent verification code');
            return APIResponse::Success($request->verification_purpose . ' Code sent successfully');
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

    public function verify(AccountRecoveryRequest $request)
    {
        try {
            $user = $this->userRepository->getWhere('email', $request->email);
            $verificationCode = $this->verificationCodeRepository->exists($user->id, $request->verification_code, $request->verification_purpose_id);
            if (!$verificationCode)
                return APIResponse::NotFound('Invalid Verification Code');
            if ($this->verificationCodeRepository->Expired($verificationCode))
                return APIResponse::Gone('Code is expired');
            if ($this->verificationCodeRepository->verified($verificationCode))
                return APIResponse::Gone('Code is already verified');
            if (!$this->verificationCodeRepository->verify($verificationCode))
                return APIResponse::UnknownInternalServerError('Could not verify code');
            return APIResponse::Success('Code verified successfully');
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

    public function reset(PasswordResetRequest $request)
    {
        try {
            $user = $this->userRepository->getWhere('email', $request->email);
            $verificationCode = $this->verificationCodeRepository->exists($user->id, $request->verification_code, $request->verification_purpose_id);
            if (!$verificationCode)
                return APIResponse::NotFound('Invalid Verification Code');
            // if ($this->verificationCodeRepository->Expired($verificationCode))
            //     return APIResponse::Gone('Code is expired');
            if (!$this->verificationCodeRepository->verified($verificationCode))
                return APIResponse::BadRequest('Please verify the code first');
            if (!$this->userRepository->updatePassword($user, $request->password))
                return APIResponse::UnknownInternalServerError('Could not reset password');
            $this->verificationCodeRepository->use($verificationCode);
            return APIResponse::Success('Password resetted successfully');
        } catch (Exception $ex) {
            return 200;
            return APIResponse::InternalServerError($ex);
        }
    }
}
