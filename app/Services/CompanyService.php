<?php

namespace App\Services;

use App\DTOs\Company\AddCompanyDTO;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\DB;

class CompanyService
{

    public function __construct(private CompanyRepository $companyRepo) {}

    /**
     * recieveing `$data` and `$user` then passing it into repository for
     * company creation base on `$user` and `$data` info
     * @param AddCompanyDTO $data
     * @param User $user
     */
    public function addCompany(AddCompanyDTO $data, User $user)
    {
        return DB::transaction(fn() => $this->companyRepo->addCompany($data, $user));
    }
}
