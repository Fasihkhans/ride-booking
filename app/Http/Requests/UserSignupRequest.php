<?php

namespace App\Http\Requests;

use App\Helpers\APIResponse;
use App\Helpers\Configuration;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;



class UserSignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
            'lastName' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users'],
            'phoneNumber' => ['required', 'regex:/^\+?[0-9\-\s]+$/'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phoneNumber
        ]);
    }
     /**
     * Hashing Password.
     * Assigning Role
     */
    public function getValidatorInstance()
    {
        if (parent::getValidatorInstance()->fails()) {
            $this->failedValidation(parent::getValidatorInstance());
        }
        $this->merge([
            'password' => Hash::make($this->request->get('password')),
            'role_id' => Configuration::UserRole('user'),
        ]);
        $this->merge([
            'verification_purpose_id' => Configuration::VerificationPurpose('Account Verification'),
        ]);
        return parent::getValidatorInstance();
    }

    /**
     *
     * @return json
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(APIResponse::BadRequest($validator->errors()->first()));
    }
}
