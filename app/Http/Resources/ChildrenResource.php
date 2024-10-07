<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;

class ChildrenResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstname,
            'lastName' => $this->last_name,
            'middleName' => $this->middle_name,
            'fullName' => $this->first_name . ' ' . $this->middle_name ?? '' . ' ' . $this->last_name,
            'dateOfBirth' => $this->date_of_birth,
            'age' => Carbon::parse($this->date_of_birth)->longAbsoluteDiffForHumans(),
            'image' => URL::asset($this->image) ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
            'department' => new ChildDepartmentResource($this->whenLoaded('department')),
        ];
    }

}
