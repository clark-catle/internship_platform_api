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
            'user' => UserResource::make($request->user()),
            'student' => [
                'id' => $this->id,
                'school' => $this->company_name,
                'cellphone_number' => $this->description,
                'course' => CourseResource::make($this->course),
                'location' => [
                    'region' => $this->region,
                    'city' => $this->city,
                ]
            ]
        ];
    }
}
