<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Company\AddCompanyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequests\AddCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Services\CompanyService;
use Dedoc\Scramble\Attributes\Endpoint;

/**
 * @tags Company
 */
class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
    ) {}

    #[Endpoint(title: 'Add Company Info', description: 'The user that has company role can add their info about their company')]
    public function addCompany(AddCompanyRequest $request)
    {
        $validated = AddCompanyDTO::fromRequest($request);
        $user = $request->user();

        dd($validated->company_logo);

        $company =  $this->companyService->addCompany($validated, $user);

        return response()->json([
            'message' => 'Company info has been created successfully',
            'information' => CompanyResource::make($company)
        ]);
    }
}
