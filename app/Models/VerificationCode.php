<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'verification_code_method_id',
        'verification_code_status_id',
        'verification_code_purpose_id',
        'code',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'verification_code_method_id' => '1',
        'verification_code_status_id' => '1',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Purpose()
    {
        return $this->belongsTo(VerificationCodePurpose::class, 'verification_code_purpose_id', 'id');
    }

    public function Method()
    {
        return $this->belongsTo(VerificationCodeMethod::class, 'verification_code_method_id', 'id');
    }

    public function Status()
    {
        return $this->belongsTo(VerificationCodeStatus::class, 'verification_code_status_id', 'id');
    }

    public function Recipient()
    {
        if ($this->Method->name == 'email')
            return $this->User->email;
        return $this->User->phone_number;
    }

    public function Queue()
    {
        return $this->Purpose->queue == '1' ? true : false;
    }

    public function Expired()
    {
        return Carbon::now() > Carbon::parse($this->created_at)->addSeconds($this->Purpose->expiration_seconds) ? true : false;
    }

    public function Verify()
    {
        $this->verification_code_status_id = 2;
        $this->User->verified = true;
        $this->User->save();
        $this->save();
        return true;
    }

    public function Use()
    {
        $this->verification_code_status_id = 3;
        $this->save();
        return true;
    }

    public function Verified()
    {
        return $this->verification_code_status_id == 2 ? true : false;
    }
}
