<?php

namespace App\Repositories;

use App\DTOs\Company\AddCompanyDTO;
use App\Models\User;

class CompanyRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * creating a company info base on the passed `$user`
     * and `$data` then returning it
     * @param AddCompanyDTO $data
     * @param User $user
     * @return \App\Models\Company
     */
    public function addCompany(AddCompanyDTO $data, User $user)
    {
        return $user->company()->create($data->toArray());
    }
}
