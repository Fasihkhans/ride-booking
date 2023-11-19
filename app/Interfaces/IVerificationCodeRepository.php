<?php

namespace App\Interfaces;

use App\Models\VerificationCode;

interface IVerificationCodeRepository
{
    public function create(array $data);
    public function getById(int $id);
    public function getWhere(string $column, $match);

    public function generate($userId, $verificationCodePurposeId);
    public function exists(int $userId, int $code, int $purposeId);
    public function expired(VerificationCode $verificationCode);
    public function verify(VerificationCode $verificationCode);
    public function canGenerate($userId, $purposeId);

    public function use(VerificationCode $verificationCode);
    public function verified(VerificationCode $verificationCode);
}
