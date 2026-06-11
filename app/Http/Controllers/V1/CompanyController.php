<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Company\AddCompanyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest\AddCompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
    ) {}

    public function addCompany(AddCompanyRequest $request)
    {
        return $this->companyService->addCompany(AddCompanyDTO::fromRequest($request));
    }
}
