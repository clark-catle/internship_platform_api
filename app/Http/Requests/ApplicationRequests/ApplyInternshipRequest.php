<?php

namespace App\Http\Requests\ApplicationRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class ApplyInternshipRequest extends FormRequest
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
            'resume' => ['sometimes', 'nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ];
    }


    #[Override]
    public function messages()
    {
        return [
            'resume.mimes'    => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max'      => 'Resume must not exceed 5MB.',
        ];
    }
}
