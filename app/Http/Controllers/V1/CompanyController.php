<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Company\AddCompanyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest\AddCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
    ) {}

    public function addCompany(AddCompanyRequest $request)
    {
        $validated = AddCompanyDTO::fromRequest($request);
        $user = $request->user();

        $company =  $this->companyService->addCompany($validated, $user);

        return response()->json([
            'message' => 'Company info has been created successfully',
            'information' => CompanyResource::make($company)
        ]);
    }
}
