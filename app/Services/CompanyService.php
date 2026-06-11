<?php

namespace App\Services;

use App\DTOs\Company\AddCompanyDTO;

class CompanyService
{

    public function __construct() {}

    public function addCompany(AddCompanyDTO $data)
    {
        return $data;
    }
}
