<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class UserIdRequest extends FormRequest
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
            'id' => [
                'required',
                'numeric',
                'exists:users,id',
            ],
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route()->parameters()['id'],
        ]);
    }
}