<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRatingRequest extends FormRequest
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
            'user_id'=>['integer','required','exists:users,id'],
            'booking_id'=>['integer','required','exists:bookings,id'],
            'rating'=>['integer', 'between:0,5','required'],
            'review'=>['string','max:200','nullable']
        ];
    }


    protected function prepareForValidation() {
        $this->merge([
            'user_id' => $this->userId,
            'booking_id'=>$this->bookingId
        ]);
    }
}
