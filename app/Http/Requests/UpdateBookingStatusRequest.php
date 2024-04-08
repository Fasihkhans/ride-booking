<?php

namespace App\Http\Requests;

use App\Constants\Constants;
use App\Helpers\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBookingStatusRequest extends FormRequest
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
        if(Auth::user()->roles->first()->name == 'user'){

            return ['status' => ['required','string',Rule::in('cancelByUser',
                                                                      'autoCanel'
                                                                      )]];
        }
        if(in_array($this->status,['inProgress','completed'])){
            return [
                'status' => ['required','string',
                                Rule::in(
                                    'completed',
                                        'inProgress',
                                )],
                'driver_latitude' => ['required','numeric'],
                'driver_longitude' => ['required','numeric'],
            ];
        }
        return [
            'status' => ['required','string',
                            Rule::in(
                                'accepted',
                                        'declined',
                                        'autoCancel'
                            )]
        ];
    }


    protected function prepareForValidation() {
        if($this->driver){
            $this->merge([
                'driver_latitude' => $this->driver['latitude'],
                'driver_longitude' => $this->driver['longitude']
            ]);
        }
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
