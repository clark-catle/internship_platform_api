<?php

namespace App\DTOs\Student;

use App\Http\Requests\StudentRequests\EditStudentRequest;
use Illuminate\Http\UploadedFile;

class EditStudentDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly ?string $region,
        public readonly ?string $city,
        public readonly ?string $cellphone_number,
        public readonly ?string $school,
        public readonly ?int $course_id,
        public readonly ?UploadedFile $avatar_image,
        public readonly ?UploadedFile $resume_file,
        public readonly array $skills_id,
        public readonly array $other_skills
    ) {}

    public static function fromRequest(EditStudentRequest $request)
    {
        return new self(
            region: $request->string('region'),
            city: $request->string('city'),
            cellphone_number: $request->string('cellphone_number'),
            school: $request->string('school'),
            course_id: $request->validated('course_id') ?? null,
            avatar_image: $request->file('avatar_image'),
            resume_file: $request->file('resume_file'),
            skills_id: array_map('intval', $request->array('skills_id')),
            other_skills: $request->array('other_skills'),
        );
    }

    /**
     * returns an array that can be passed to updated()
     * @param null|int $avatarId
     * @param null|int $resumeId
     * @return array
     */
    public function toUpdatable(?int $avatarId, ?int $resumeId)
    {
        return array_filter([
            "region" => $this->region,
            "city" => $this->city,
            "cellphone_number" => $this->cellphone_number,
            "school" => $this->school,
            "course_id" => $this->course_id,
            "avatar_id" => $avatarId,
            "resume_id" => $resumeId,
        ], filled(...));
    }
}
