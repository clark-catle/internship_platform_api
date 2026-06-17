<?php

namespace App\Http\Requests\CompanyRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditCompanyRequest extends FormRequest
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
            'company_name'  => ['sometimes', 'nullable', 'string', 'min:5', 'max:255'],
            'logo'          => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'description'   => ['sometimes', 'nullable', 'string', 'min:20', 'max:5000'],
            'region'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'city'          => ['sometimes', 'nullable', 'string', 'max:255'],
            'website'       => ['sometimes', 'nullable', 'nullable', 'url', 'max:2083', 'regex:/^https:\/\//'],
        ];
    }
}
