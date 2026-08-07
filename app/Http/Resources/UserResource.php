<?php

namespace App\Http\Resources;

use App\Enum\User\UserRoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'status' => $this->status->value,
            'role' => $this->role,
            'company_info' => $this->when(
                ($request->user()->role === UserRoleEnum::Company || $request->user()->role === UserRoleEnum::Admin) && $this->company,
                CompanyResource::make($this->company)
            ),
            'student_info' => $this->when(
                ($request->user()->role === UserRoleEnum::Student || $request->user()->role === UserRoleEnum::Admin) && $this->student,
                StudentResource::make($this->student)
            ),
        ];
    }
}
