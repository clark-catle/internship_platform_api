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
            title: $val['title'],
            description: $val['description'],
            requirements: $val['requirements'],
            region: $val['region'],
            city: $val['city'],
            setup: $val['setup'],
            allowance: $val['allowance'],
            duration: $val['duration'],
            duration_unit: $val['duration_unit'],
            skills_id: array_map('intval', $request->array('skills_id')),
            other_skills: $request->array('other_skills'),
        );
    }
}
