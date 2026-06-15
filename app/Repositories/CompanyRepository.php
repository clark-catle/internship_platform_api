<?php

namespace App\Repositories;

use App\DTOs\Company\AddCompanyDTO;
use App\Models\Company;

class CompanyRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Company $company) {}

    /**
     * creating a new record of company base on 
     * the passed argumanents then returning it
     * @param AddCompanyDTO $data
     * @param int $userId
     * @param string $fileId
     * @return Company
     */
    public function addCompany(AddCompanyDTO $data, int $userId, string $fileId)
    {
        return $this->company->create([
            'company_name' => $data->company_name,
            'description' => $data->description,
            'region' => $data->region,
            'city' => $data->city,
            'website' => $data->website,
            'is_verified' => $data->is_verified,
            'user_id' => $userId,
            'logo_id' => $fileId
        ]);
    }
}
