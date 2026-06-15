<?php

namespace App\Http\Resources;

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
            'user' => UserResource::make($request->user()),
            'company' => [
                'id' => $this->id,
                'company_name' => $this->company_name,
                'company_logo_path' => $this->logo->path,
                'description' => $this->description,
                'region' => $this->region,
                'city' => $this->city,
                'website' => $this->website,
                'is_verified' => $this->is_verified,
                'created_at' => $this->created_at
            ]
        ];
    }
}
