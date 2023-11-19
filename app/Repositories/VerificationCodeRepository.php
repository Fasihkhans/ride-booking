<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Interfaces\IVerificationCodeRepository;
use App\Models\VerificationCode;
use Carbon\Carbon;

class VerificationCodeRepository implements IVerificationCodeRepository
{
    public function getById(int $id)
    {
        return VerificationCode::find($id);
    }

    public function create(array $data)
    {
        return VerificationCode::create($data);
    }

    public function getWhere($column, $match)
    {
        return VerificationCode::where($column, $match)->first();
    }

    public function generate($userId, $verificationCodePurposeId)
    {
        return VerificationCode::create([
            'user_id' => $userId,
            'verification_code_purpose_id' => $verificationCodePurposeId,
            'code' => Helper::randomNumber(4)
        ]);
    }

    public function exists(int $userId, int $code, int $purposeId)
    {
        return VerificationCode::where([
            ['user_id', $userId],
            ['code', $code],
            ['verification_code_purpose_id', $purposeId],
            ['verification_code_status_id', '!=', '3']
        ])->first();
    }

    public function expired(VerificationCode $verificationCode)
    {
        return $verificationCode->Expired();
    }

    public function verify(VerificationCode $verificationCode)
    {
        return $verificationCode->Verify();
    }

    public function canGenerate($userId, $purposeId)
    {
        return VerificationCode::where([
            ['user_id', $userId],
            ['verification_code_purpose_id', $purposeId],
            ['created_at', '>', Carbon::now()->addSeconds(-35)]
        ])->count() > 0 ? false : true;
    }

    public function use(VerificationCode $verificationCode)
    {
        return $verificationCode->Use();
    }

    public function verified(VerificationCode $verificationCode)
    {
        return $verificationCode->Verified();
    }
}
