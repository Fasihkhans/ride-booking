<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\APIResponse;
use App\Helpers\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountVerificationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserLogoutRequest;
use App\Http\Requests\UserSignupRequest;
use App\Http\Requests\VerificationCodeRequest;
use App\Http\Resources\LoggedInUserResource;
use App\Interfaces\IVerificationCodeRepository;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    private IUserRepository $userRepository;
    private IVerificationCodeRepository $verificationCodeRepository;

    public function __construct(IUserRepository $userRepository, IVerificationCodeRepository $verificationCodeRepository)
    {
        $this->userRepository = $userRepository;
        $this->verificationCodeRepository = $verificationCodeRepository;
    }

    public function signup(UserSignupRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->all());
            if (!$user)
            return APIResponse::UnknownInternalServerError('User account not created');
            $user->assignRole(Role::findById($user->role_id, 'api'));
            if (Configuration::Get('require_email_verification') == '1' && $this->userRepository->hasRole($user, 'user'))
                $this->verificationCodeRepository->generate($user->id, $request->verification_purpose_id);
            return APIResponse::ResourceCreated('Account created successfully');
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $user = $this->userRepository->getWhere('email', $request->email);
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                return APIResponse::BadRequest(
                    $this->userRepository->hasOAuth($user) ?
                        'You tried signing in via Email, which is not the authentication method you used during sign up. Try again using the authentication method you used during sign up' :
                        'Incorrect email or password'
                );
            if (!($this->userRepository->hasRole($user, 'user')|| $this->userRepository->hasRole($user, 'driver')))
                return APIResponse::Forbidden('Account restricted');
            if (!$this->userRepository->allowedLogin($user))
                return APIResponse::Forbidden('Account ' . $this->userRepository->getStatus($user));
            if (!$this->userRepository->isVerified($user))
                return APIResponse::BadRequest('Account not verified');
            $user->secret = $this->userRepository->generateBearerToken($user, !Configuration::Get('allow_multi_device_login'));
            return APIResponse::SuccessWithData('Logged in successfully', new LoggedInUserResource($user));
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }
    public function verify(AccountVerificationRequest $request)
    {
        try {
            $user = $this->userRepository->getWhere('email', $request->email);
            if ($this->userRepository->isVerified($user))
                return APIResponse::Unauthorized('Account already verified');
            $verificationCode = $this->verificationCodeRepository->exists($user->id, $request->verification_code, $request->verification_purpose_id);
            if (!$verificationCode)
                return APIResponse::NotFound('Invalid Verification Code');
            if ($this->verificationCodeRepository->expired($verificationCode))
                return APIResponse::Gone('Code is expired');
            if (!$this->verificationCodeRepository->verify($verificationCode))
                return APIResponse::UnknownInternalServerError('Could not verify code');
            $this->verificationCodeRepository->use($verificationCode);
            $this->userRepository->updateStatus($user,1);
            return APIResponse::Success('Account verified successfully');
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

    public function send(VerificationCodeRequest $request)
    {
        try {
            $user = $this->userRepository->getWhere('email', $request->email);
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                return APIResponse::Unauthorized(
                    $this->userRepository->hasOAuth($user) ?
                        'You tried signing in via Email, which is not the authentication method you used during sign up. Try again using the authentication method you used during sign up' :
                        'Incorrect email or password'
                );
            if ($this->userRepository->isVerified($user))
                return APIResponse::Conflict('Account is already verified');
            if (!$this->verificationCodeRepository->canGenerate($user->id, $request->verification_purpose_id))
                return APIResponse::TooManyRequests('Too many requests. Please try later');
            $verificationCode = $this->verificationCodeRepository->generate($user->id, $request->verification_purpose_id);
            if (!$verificationCode)
                return APIResponse::UnknownInternalServerError('Could not sent verification code');
            return APIResponse::Success($request->verification_purpose . ' code sent successfully');
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }

    public function logout(UserLogoutRequest $request)
    {
        try {
            if ($this->userRepository->logout($request->user(), $request->from_everywhere))
                return APIResponse::Success('Logged out successfully');
            return APIResponse::UnknownInternalServerError('Could not logout');
        } catch (Exception $ex) {
            return APIResponse::InternalServerError($ex);
        }
    }
}