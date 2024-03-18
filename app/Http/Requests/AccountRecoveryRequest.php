<?php

namespace App\Http\Requests;

use App\Helpers\APIResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Configuration;
use App\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountRecoveryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'exists:users', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255'],
            'verification_code' => ['required', 'numeric', 'digits:4'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'Email',
            'verification_code' => 'Verification Code',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required'         => ':attribute field cannot be left empty',
            'email.email'        => 'Please enter a valid :attribute',
            'email.exists'        => 'No account found against this :attribute',
            'verification_code.numeric' => 'Verification Code must be of 4 digit number',
            'verification_code.digits' => 'Verification Code must be of 4 digits',
        ];
    }

    /**
     * Injecting Verification Purpose.
     */
    public function getValidatorInstance()
    {
        $this->merge([
            'verification_purpose_id' => Configuration::VerificationPurpose('Account Recovery'),
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
