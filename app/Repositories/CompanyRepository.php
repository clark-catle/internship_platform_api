<?php

namespace App\Repositories;

use App\DTOs\Company\AddCompanyDTO;
use App\Models\Company;
use App\Models\User;

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

    /**
     * checks if the `$user` info has a company info
     * @param User $user
     * @return bool
     */
    public function companyExist(User $user)
    {
        return $user->company()->exists();
    }

    /**
     * updating the info of `$company` base on the passed `$data`
     * @param Company $company
     * @param array $data
     */
    public function editCompany(Company $company, array $data)
    {
        $company->update($data);
    }

    /**
     * gets all the company info
     * @return \Illuminate\Database\Eloquent\Collection<int, Company>
     */
    public function getAllCompany()
    {
        return $this->company->all();
    }

    /**
     * change the verification value of `$company`
     * base on the passed `$val` value
     * @param Company $company
     * @param bool $val
     * @return Company
     */
    public function changeVerification(Company $company, bool $val)
    {
        $company->update(['is_verified' => $val]);

        return $company;
    }
}
