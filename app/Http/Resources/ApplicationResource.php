<?php

namespace App\Http\Resources;

use App\Enum\User\UserRoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'status' => $this->status->value,
            'progress' => $this->progress->value,
            'applied_at' => $this->applied_at,
            'student' => $this->when(
                $request->user()->role !== UserRoleEnum::Student,
                StudentResource::make($this->student)
            ),
            'internship' => InternshipResource::make($this->internship)
        ];
    }
}
