<?php

namespace App\DTOs\Company;

use App\Http\Requests\CompanyRequests\AddCompanyRequest;
use Illuminate\Http\UploadedFile;

class AddCompanyDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $company_name,
        public readonly UploadedFile $company_logo,
        public readonly string $description,
        public readonly string $region,
        public readonly string $city,
        public readonly string $website,
        public readonly bool $is_verified = false
    ) {}

    public static function fromRequest(AddCompanyRequest $request)
    {
        $validated = $request->validated();

        return new self(
            company_name: $validated['company_name'],
            company_logo: $request->file('company_logo'),
            description: $validated['description'],
            region: $validated['region'],
            city: $validated['city'],
            website: $validated['website'],
        );
    }

    public function toArray()
    {
        return [
            'company_name' => $this->company_name,
            'company_logo' => $this->company_logo,
            'description' => $this->description,
            'region' => $this->region,
            'city' => $this->city,
            'website' => $this->website,
            'is_verified' => $this->is_verified
        ];
    }
}
