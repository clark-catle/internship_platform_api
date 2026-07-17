<?php

namespace App\DTOs\Internship;

use App\Enum\Internship\InternshipAllowanceEnum;
use App\Enum\Internship\InternshipDurationUnitEnum;
use App\Enum\Internship\InternshipSetupEnum;
use App\Http\Requests\InternshipRequests\EditInternshipRequest;

class EditInternshipDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $requirements,
        public readonly ?string $region,
        public readonly ?string $city,
        public readonly ?InternshipSetupEnum $setup,
        public readonly ?InternshipAllowanceEnum $allowance,
        public readonly ?int $duration,
        public readonly ?InternshipDurationUnitEnum $duration_unit,
        public readonly array $skills_id,
        public readonly array $other_skills,
    ) {}

    public static function fromRequest(EditInternshipRequest $request)
    {
        $val = $request->validated();

        return new self(
            title: $request->string('title'),
            description: $request->string('description'),
            requirements: $request->string('requirements'),
            region: $request->string('region'),
            city: $request->string('city'),
            setup: InternshipSetupEnum::tryFrom($request->string('setup')),
            allowance: InternshipAllowanceEnum::tryFrom($request->string('allowance')),
            duration: $request->integer('duration') !== 0 ? $request->integer('duration') : null,
            duration_unit: InternshipDurationUnitEnum::tryFrom($request->string('duration_unit')),
            skills_id: array_map('intval', $request->array('skills_id')),
            other_skills: $request->array('other_skills'),
        );
    }

    /**
     * returns an array that can be passed to updated()
     * @return array
     */
    public function toUpdatable()
    {
        return array_filter([
            "title" => $this->title,
            "description" => $this->description,
            "requirements" => $this->requirements,
            "region" => $this->region,
            "city" => $this->city,
            "setup" => $this->setup,
            "allowance" => $this->allowance,
            "duration" => $this->duration,
            "duration_unit" => $this->duration_unit,
        ], filled(...));
    }
}
