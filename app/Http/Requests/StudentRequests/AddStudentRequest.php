<?php

namespace App\Http\Requests\StudentRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class AddStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'region'           => ['required', 'string', 'max:255'],
            'city'             => ['required', 'string', 'max:255'],
            'cellphone_number' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'school'           => ['sometimes', 'nullable', 'string', 'max:255'],
            'course_id'        => ['sometimes', 'nullable', 'int', 'exists:courses,id'],
            'avatar_image'     => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'resume_file'      => ['sometimes', 'nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'skills_id'        => ['sometimes', 'nullable', 'array'],
            'skills_id.*'      => ['required', 'integer', 'exists:skills,id', 'distinct'],
            'other_skills'     => ['sometimes', 'nullable', 'array'],
            'other_skills.*'   => ['required', 'string', 'max:255', 'distinct:ignore_case']
        ];
    }


    #[Override]
    public function messages()
    {
        return [
            'cellphone_number.regex'    => 'Cellphone number must be a valid Philippine number starting with 09',
            'course_id.exists'          => 'Only pick in the provided courses.',
            'avatar_image.mimes'        => 'Profile picture must be a JPEG, JPG, PNG, or WebP file.',
            'avatar_image.max'          => 'Profile picture must not exceed 5MB.',
            'resume_file.mimes'         => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume_file.max'           => 'Resume must not exceed 10MB.',
            'skills_id.*.required'      => 'Pick a skill in the provided skills',
            'skills_id.*.exists'        => 'Pick a skill in the provided skills',
            'skills_id.*.distinct'      => 'Duplicate skills are not allowed.',
            'other_skills.*.required'   => 'Add a name for the skill that is not in the skill list',
            'other_skills.*.distinct'   => 'Duplicate skills are not allowed.',
        ];
    }
}
