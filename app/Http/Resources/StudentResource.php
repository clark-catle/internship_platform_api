<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'school' => $this->school,
            'cellphone_number' => $this->cellphone_number,
            'course' => CourseResource::make($this->course),
            'location' => [
                'region' => $this->region,
                'city' => $this->city,
            ],
            'student_skill' => SkillResource::collection($this->skill)
        ];
    }
}
