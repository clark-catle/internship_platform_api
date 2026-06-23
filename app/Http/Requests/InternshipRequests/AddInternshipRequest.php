<?php

namespace App\Http\Requests\InternshipRequests;

use App\Enum\Internship\InternshipAllowanceEnum;
use App\Enum\Internship\InternshipDurationUnitEnum;
use App\Enum\Internship\InternshipSetupEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class AddInternshipRequest extends FormRequest
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
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'requirements'      => ['required', 'string'],
            'region'            => ['sometimes', 'nullable', 'string', 'max:255'],
            'city'              => ['sometimes', 'nullable', 'string', 'max:255'],
            'setup'             => ['required', Rule::enum(InternshipSetupEnum::class)],
            'allowance'         => ['required', Rule::enum(InternshipAllowanceEnum::class)],
            'duration'          => ['required', 'integer', 'min:1'],
            'duration_unit'     => ['required', Rule::enum(InternshipDurationUnitEnum::class)],
            'skills_id'         => ['sometimes', 'nullable', 'array'],
            'skills_id.*'       => ['required', 'integer', 'exists:skills,id', 'distinct'],
            'other_skills'      => ['sometimes', 'nullable', 'array'],
            'other_skills.*'    => ['required', 'string', 'max:255', 'distinct:ignore_case']
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'setup.enum'                => 'Choose in the provided setup option',
            'allowance.enum'            => 'Choose in the provided allowance option',
            'duration_unit.enum'        => 'Choose in the provided duration unit option',
            'skills_id.*.required'      => 'Pick a skill in the provided skills',
            'skills_id.*.exists'        => 'Pick a skill in the provided skills',
            'skills_id.*.distinct'      => 'Duplicate skills are not allowed.',
            'other_skills.*.required'   => 'Add a name for the skill that is not in the skill list',
            'other_skills.*.distinct'   => 'Duplicate skills are not allowed.',
        ];
    }
}
