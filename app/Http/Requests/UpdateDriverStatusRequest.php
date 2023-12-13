<?php

namespace App\Http\Requests;

use App\Helpers\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateDriverStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required','string',
                         Rule::in(
                            'active',
                            'inActive',
                        )]
        ];
    }

    /**
     *
     * @return APIResponse
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(APIResponse::BadRequest($validator->errors()->first()));
    }

}