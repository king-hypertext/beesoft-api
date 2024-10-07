<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;

class OrganizationResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'post_office_address' => $this->postr_office_address,
            'image' =>  $this->image !== null ? URL::asset($this->image) : '',
            'sms_api_key' => $this->sms_api_key,
            'sms_api_secret_key' => $this->sms_api_secret_key,
            'sms_provider' => $this->sm_provider,
            'manage_clock_in' => $this->manage_clock_in,
            'signature_clock_in' => $this->signature_clock_in,
            'account_status' => new UserAccountStatusResource($this->whenLoaded('account_status')),
            'category' => new OrganizationCategoryResource($this->whenLoaded('category')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
