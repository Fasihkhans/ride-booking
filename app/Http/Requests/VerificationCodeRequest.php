<?php

namespace App\Http\Requests;

use App\Helpers\APIResponse;
use App\Helpers\Configuration;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerificationCodeRequest extends FormRequest
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
            'verification_purpose' => ['required', 'string', Rule::in(Configuration::VerificationPurposes(false))],
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
            'verification_purpose' => 'Verification reason'
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
            'verification_purpose.in'    => 'invalid :attribute - must be among ' . Configuration::VerificationPurposes(true),
        ];
    }

    /**
     * Determine Purpose.
     *
     */
    public function getValidatorInstance()
    {
        $this->modifyData();
        return parent::getValidatorInstance();
    }

    protected function modifyData()
    {
        if (parent::getValidatorInstance()->fails()) {
            $this->failedValidation(parent::getValidatorInstance());
        }
        $this->merge([
            'verification_purpose_id' => Configuration::VerificationPurpose($this->request->get('verification_purpose')),
        ]);
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
