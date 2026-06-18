<?php

namespace App\DTOs\Company;

use App\Http\Requests\CompanyRequests\EditCompanyRequest;
use App\Models\File;
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

    public static function fromRequest(EditCompanyRequest $request)
    {
        return new self(
            company_name: $request->string('company_name'),
            logo: $request->file('logo'),
            description: $request->string('description'),
            region: $request->string('region'),
            city: $request->string('city'),
            website: $request->string('website'),
        );
    }

    /**
     * returns an array that can be passed to updated()
     * @param mixed $file
     * @return array
     */
    public function toUpdatable(?File $file)
    {
        return array_filter([
            "company_name" => $this->company_name,
            "logo_id" => $file->id,
            "description" => $this->description,
            "region" => $this->region,
            "city" => $this->city,
            "website" => $this->website,
        ], filled(...));
    }
}
