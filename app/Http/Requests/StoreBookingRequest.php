<?php

namespace App\Http\Requests;

use App\Constants\Constants;
use App\Helpers\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
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
            'data' => ['required','array'],
            'data.*.stop' => ['required','string'],
            'data.*.latitude' => ['required','numeric'],
            'data.*.longitude' => ['required','numeric'],
            'data.*.sequenceNo' => ['required','integer'],
            'data.*.type' => ['required','string',Rule::in(
                                            Constants::BOOKING_STOP_TYPE_PICKUP,
                                            Constants::BOOKING_STOP_TYPE_MID_STOP,
                                            Constants::BOOKING_STOP_TYPE_DROP_OFF
                                            )],
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->input('data');

        if ($data && is_array($data)) {
            $transformedData = array_map(function ($item) {
                if (isset($item['sequenceNo'])) {
                    $item['sequence_no'] = $item['sequenceNo'];
                    // unset($item['sequence_no']);
                }

                return $item;
            }, $data);

            $this->merge([
                'data' => $transformedData,
            ]);
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'data.*.*.required' => 'The :attribute field is required.',
            'data.*.sequenceNo.integer' => 'The :attribute must be an integer.',
            'data.*.stop.string' => 'The :attribute must be a string.',
            'data.*.latitude.numeric' => 'The :attribute must be a number.',
            'data.*.longitude.numeric' => 'The :attribute must be a number.',
        ];
    }


    /**
     *
     * @return /json
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(APIResponse::BadRequest($validator->errors()->first()));
    }
}