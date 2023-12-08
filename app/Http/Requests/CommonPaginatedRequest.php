<?php

namespace App\Http\Requests;

use App\Helpers\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommonPaginatedRequest extends FormRequest
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
            'per_page' => ['numeric', 'gte:0', 'lte:50'],
            'page' => ['numeric', 'gte:1'],
            'sort_by' => ['string'],
            'sort_order' => ['in:asc,desc'],
            'search' => ['string'],
            // Add more rules for additional attributes if needed
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
            'per_page' => 'Result count',
            'page' => 'Page number',
            'sort_by' => 'Sort by',
            'sort_order' => 'Sort order',
            'search' => 'Search query',
            // Add more custom attribute names if needed
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'per_page' => $this->perPage ?? 10,
            'page' => $this->page ?? 1,
            'sort_order' => $this->sortOrder ?? 'asc',
            'sort_by' => $this->sortBy
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required' => ':attribute field cannot be left empty',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(APIResponse::BadRequest($validator->errors()->first()));
    }
}
