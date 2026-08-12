<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Company\AddCompanyDTO;
use App\DTOs\Company\EditCompanyDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\CompanyVerificationRequest;
use App\Http\Requests\CompanyRequests\AddCompanyRequest;
use App\Http\Requests\CompanyRequests\EditCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\FileService;
use Dedoc\Scramble\Attributes\Endpoint;

/**
 * @tags Company
 */
class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService,
        private FileService $fileService
    ) {}

    #[Endpoint(title: 'Add Company Info', description: 'The user that has company role can add their info about their company')]
    public function addCompany(AddCompanyRequest $request)
    {
        $validated = AddCompanyDTO::fromRequest($request);
        $user = $request->user();

        $company =  $this->companyService->addCompany($validated, $user);

        return response()->json([
            'message' => 'Company info has been created successfully',
            'information' => UserResource::make($company)
        ]);
    }


    #[Endpoint(title: 'Edit Company Info', description: 'The user that has company role can edit their info about their company')]
    public function editCompany(EditCompanyRequest $request)
    {
        $validated = EditCompanyDTO::fromRequest($request);
        $user = $request->user();

        $company = $this->companyService->editCompany($validated, $user);

        return response()->json([
            'message' => 'Company info has been updated successfully',
            'information' => UserResource::make($company)
        ]);
    }

    #[Endpoint(title: 'Get Company info', description: 'The user that has a company role can get their user info with their company info')]
    public function getCompany()
    {
        $user = request()->user();

        return UserResource::make($this->companyService->getCompany($user));
    }

    #[Endpoint(title: 'View all company', description: 'The user can freely view all company as long as the user isnt a company role and will only return info of the company')]
    public function viewCompany()
    {
        return CompanyResource::collection($this->companyService->getAllCompany());
    }

    #[Endpoint(title: 'View specific company', description: 'The user can freely view other specific company as long as the user isn\'t a company role and will only return info of the company')]
    public function viewSpecificCompany(Company $company)
    {
        return CompanyResource::make($company);
    }

    #[Endpoint(title: 'Get company logo', description: 'The user that isnt a company user can request the company logo (might be because viewing of internship)')]
    public function getCompanyLogo(Company $company)
    {
        return $this->fileService->getFile($company->logo);
    }

    #[Endpoint(title: 'Get own company logo', description: 'The user that is a company user can get their ownt logo')]
    public function getLogo()
    {
        return $this->companyService->getLogo(request()->user());
    }

    #[Endpoint(title: 'Change company verification', description: 'The user that is an admin can change the company verification value')]
    public function changeVerification(CompanyVerificationRequest $request, Company $company)
    {
        return response()->json([
            'message' => "The company verification has been changed successfully!",
            'company' => CompanyResource::make($this->companyService->changeVerification($company, $request->boolean('verification')))
        ]);
    }
}
