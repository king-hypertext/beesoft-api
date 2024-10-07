<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
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
        $hasPhone = [
            'phone' => 'required|numeric|max_digits:10'
        ];
        $hasLocation = [
            'community' => 'required|string',
            'district' => 'required|exists:districts,id',
            'city' => 'required|exists:city,id'
        ];
        $rule = [
            'name' => 'required|string',
            'post_office_address' => 'required|string',
            'admin' => 'required|exists:users,id',
            'image' => 'nullable|file|mimes:png,jpg,jpeg,webp|max:2048',
            'category' => 'required|exists:organization_categories,id',
            'email' => 'required|email',
            // 'activated_by' => 'required|exists:users,id',
            'account_status' => 'required|exists:account_status,id',
            'sms_api_key' => 'nullable|string',
            'sms_api_secret_key' => 'nullable|string',
            'sms_provider' => 'nullable|string',
            'manage_clock_in' => 'nullable|boolean',
            'signature_clock_in' => 'nullable|boolean',
        ];

        if (!request()->has('community') || !request()->has('phone')) {
            return $rule;
        }
        return array_merge($rule, $hasLocation, $hasPhone);
    }
    public function messages()
    {
        return  [
            'email.email' => 'the provided email address is not valid',
            'category.exists' => 'the selected category does not exist',
            'admin.exists' => 'the selected user does not exist',
            'manage_clock_in.boolean' => 'must be true (1) or false (0)',
            'signature_clock_in.boolean' => 'must be true (1) or false (0)',
            'image.max' => 'image size must not be greater than 2MB'
        ];
    }
}
