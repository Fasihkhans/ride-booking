<?php

namespace App\Http\Requests;

use App\Helpers\APIResponse;
use App\Helpers\Configuration;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
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
            'password' => ['required', 'string', 'exists:users', 'min:8']
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
            'password' => 'Password',
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
        ];
    }

    /**
     * Determining Device Platform.
     *
     */
    public function getValidatorInstance()
    {
        if (parent::getValidatorInstance()->fails()) {
            $this->failedValidation(parent::getValidatorInstance());
        }
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



