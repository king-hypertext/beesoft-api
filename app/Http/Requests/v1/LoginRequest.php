<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|exists:users,email',
            'phone_number' => 'required|numeric|exists:users,phone_number',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'email is required to login',
            'email.exists' => 'the provided email does not exist',
            'phone_number.required' => 'phone number is required to login',
            // 'phone_number.numeric' => 'phone number must be only numbers',
            'phone_number.exists' => 'the provided phone number does not exist',
        ];
    }
}
