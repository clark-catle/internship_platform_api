<?php

namespace App\DTOs\Student;

use App\Http\Requests\StudentRequests\AddStudentRequest;
use Illuminate\Http\UploadedFile;

class AddStudentDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $region,
        public readonly string $city,
        public readonly string $cellphone_number,
        public readonly ?string $school,
        public readonly ?int $course_id,
        public readonly ?UploadedFile $avatar_image,
        public readonly ?UploadedFile $resume_file,
    ) {}

    public static function fromRequest(AddStudentRequest $request)
    {
        return new self(
            region: $request->string('region'),
            city: $request->string('city'),
            cellphone_number: $request->string('cellphone_number'),
            school: $request->string('school'),
            course_id: $request->integer('course_id'),
            avatar_image: $request->file('avatar_image'),
            resume_file: $request->file('resume_file'),
        );
    }
}
