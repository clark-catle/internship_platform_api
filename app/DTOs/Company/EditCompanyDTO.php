<?php

namespace App\DTOs\Company;

use App\Http\Requests\CompanyRequests\EditCompanyRequest;
use Illuminate\Http\UploadedFile;

class EditCompanyDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly ?string $company_name,
        public readonly ?UploadedFile $logo,
        public readonly ?string $description,
        public readonly ?string $region,
        public readonly ?string $city,
        public readonly ?string $website,
    ) {}

    public function fromRequest(EditCompanyRequest $request)
    {
        $val = $request->validated();

        return new self(
            company_name: $val['company_name'],
            logo: $request->file('logo'),
            description: $val['description'],
            region: $val['region'],
            city: $val['city'],
            website: $val['website'],
        );
    }

    public function toUpdatable()
    {
        return array_filter([
            "company_name" => $this->company_name,
            "logo" => $this->logo,
            "description" => $this->description,
            "region" => $this->region,
            "city" => $this->city,
            "website" => $this->website,
        ], fn($val) => filled($val));
    }
}
