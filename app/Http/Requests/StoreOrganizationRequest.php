<?php

namespace App\Http\Requests;

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
        return [
            'name' => 'required|string',
            'post_office_address' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|file|mimes:png,jpg,jpeg,webp',
            'category' => 'required|exists:organization_categories,id',
            'email' => 'required|email',
            'activated_by' => 'required|exists:users,id',
            'account_status' => 'required|exists:account_status,id',

        ];
    }
    public function messages()
    {
        return  [
            'email.email' =>'the provided email address is not valid',
            'category.exists' =>'the selected category does not exist',
            'user_id.exists' =>'the selected user does not exist',
        ];
    }
}
