<?php

namespace App\Http\Resources;

use App\Enum\User\UserRoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'description' => $this->description,
            'website' => $this->website,
            'is_verified' => $this->is_verified,
            'location' => [
                'region' => $this->region,
                'city' => $this->city,
            ]
        ];
    }
}
