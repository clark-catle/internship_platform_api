<?php

namespace App\Http\Requests\InternshipRequests;

use App\Enum\Internship\InternshipAllowanceEnum;
use App\Enum\Internship\InternshipDurationUnitEnum;
use App\Enum\Internship\InternshipSetupEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'requirements'  => ['required', 'string'],
            'region'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'city'          => ['sometimes', 'nullable', 'string', 'max:255'],
            'setup'         => ['required', 'string', Rule::enum(InternshipSetupEnum::class)],
            'allowance'     => ['required', 'string', Rule::enum(InternshipAllowanceEnum::class)],
            'duration'      => ['required', 'integer', 'min:1'],
            'duration_unit' => ['required', 'string', Rule::enum(InternshipDurationUnitEnum::class)],
        ];
    }
}
