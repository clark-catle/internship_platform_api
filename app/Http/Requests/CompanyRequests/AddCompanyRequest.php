<?php

namespace App\Http\Requests\CompanyRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class AddCompanyRequest extends FormRequest
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
            'company_name'  => ['required', 'string', 'min:5', 'max:255'],
            'logo'          => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'description'   => ['required', 'string', 'min:20', 'max:5000'],
            'region'        => ['required', 'string', 'max:255'],
            'city'          => ['required', 'string', 'max:255'],
            'website'       => ['sometimes', 'nullable', 'url', 'max:2083', 'regex:/^https:\/\//'],
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'logo.mimes'    => 'Profile picture must be a JPEG, JPG, PNG, or WebP file.',
            'logo.max'      => 'Profile picture must not exceed 5MB.',
            'website.regex' => 'Website must use HTTPS.',
            'website.url'   => 'Website must be a valid URL.',
        ];
    }
}
