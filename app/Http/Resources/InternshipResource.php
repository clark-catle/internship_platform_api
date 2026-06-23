<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternshipResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'region' => $this->region,
            'city' => $this->city,
            'setup' => $this->setup->value,
            'allowance' => $this->allowance->value,
            'duration' => $this->duration,
            'duration_unit' => $this->duration_unit->value,
            'internship_skill' => SkillResource::collection($this->skill),
            'company' => CompanyResource::make($this->company)
        ];
    }
}
