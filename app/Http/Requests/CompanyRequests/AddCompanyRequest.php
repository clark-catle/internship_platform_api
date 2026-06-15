<?php

namespace App\Http\Requests\CompanyRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'company_name'  => ['required', 'string', 'max:255', 'unique:companies,company_name'],
            'company_logo'  => ['required', 'max:2048'],
            'description'   => ['required', 'string', 'max:5000'],
            'region'        => ['required', 'string', 'max:255'],
            'city'          => ['required', 'string', 'max:255'],
            'website'       => ['nullable', 'url', 'max:255'],
        ];
    }
}
