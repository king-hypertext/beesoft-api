<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'fullName' => $this->fullname,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'account_status' => new UserAccountStatusResource($this->whenLoaded('account_status')),
            'role' => new UserRoleResource($this->whenLoaded('role')),
            'image' =>  $this->image !== null ? URL::asset($this->image) : '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
