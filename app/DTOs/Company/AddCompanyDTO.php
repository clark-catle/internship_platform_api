<?php

namespace App\DTOs\Company;

use App\Http\Requests\CompanyRequest\AddCompanyRequest;

class AddCompanyDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $company_name,
        public readonly string $company_logo_path,
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
            company_logo_path: $validated['company_logo_path'],
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
            'company_logo_path' => $this->company_logo_path,
            'description' => $this->description,
            'region' => $this->region,
            'city' => $this->city,
            'website' => $this->website,
            'is_verified' => $this->is_verified
        ];
    }
}
