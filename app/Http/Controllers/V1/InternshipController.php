<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Internship\AddInternshipDTO;
use App\DTOs\Internship\EditInternshipDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipRequests\AddInternshipRequest;
use App\Http\Requests\InternshipRequests\EditInternshipRequest;
use App\Http\Resources\InternshipResource;
use App\Models\Internship;
use App\Services\InternshipService;
use Dedoc\Scramble\Attributes\Endpoint;

/**
 * @tags Internship
 */
class InternshipController extends Controller
{
    public function __construct(private InternshipService $internshipService) {}

    #[Endpoint(title: 'Company View internship', description: 'The user that has a company role can see all of their own posted internship info')]
    public function companyInternship()
    {
        $user = request()->user();
        $internship = $this->internshipService->companyInternship($user);

        return InternshipResource::collection($internship);
    }

    #[Endpoint(title: 'Company View Specific Internship', description: 'The user that has a company role can see their specific internship info')]
    public function specificCompanyInternship(Internship $internship)
    {
        $this->authorize('access', $internship);

        return InternshipResource::make($internship);
    }

    #[Endpoint(title: 'View All Internship', description: 'The user that doesn\'t have a company role can see all the available internship')]
    public function viewInternship()
    {
        return InternshipResource::collection($this->internshipService->viewInternship());
    }

    #[Endpoint(title: 'View Specific Internship', description: 'The user that doesn\'t have a company role can see the specific internship')]
    public function viewSpecificInternship(Internship $internship)
    {
        return InternshipResource::make($internship->load(['skill', 'company']));
    }

    #[Endpoint(title: 'Create Internship', description: 'The user that has a company role can create their own internship info')]
    public function addInternship(AddInternshipRequest $request)
    {
        $data = AddInternshipDTO::fromRequest($request);
        $user = $request->user();

        $internship = $this->internshipService->addInternship($data, $user);

        return response()->json([
            'message' => 'Internship has been created successfully',
            'information' => InternshipResource::make($internship)
        ]);
    }

    #[Endpoint(title: 'Edit Internship', description: 'The user that has a company role can edit their own internship info and not other\'s internship')]
    public function editInternship(EditInternshipRequest $request, Internship $internship)
    {
        $this->authorize('access', $internship);

        $data = EditInternshipDTO::fromRequest($request);

        $internship = $this->internshipService->editInternship($internship, $data);

        return response()->json([
            'message' => 'Internship has been updated successfully',
            'information' => InternshipResource::make($internship)
        ]);
    }

    #[Endpoint(title: 'Delete Internship', description: 'The user that has a company role can delete their own internship info and not other\'s internship')]
    public function deleteInternship(Internship $internship)
    {
        $this->authorize('access', $internship);

        $this->internshipService->deleteInternship($internship);

        return response()->json([
            'message' => 'Internship has been deleted successfully',
        ]);
    }

    #[Endpoint(title: 'Restore Internship', description: 'The user that has a company role can restore their own internship that has been deleted not other\'s internship')]
    public function restoreInternship(Internship $internship)
    {
        $this->authorize('access', $internship);

        $this->internshipService->restoreInternship($internship);

        return response()->json([
            'message' => 'Internship has been deleted successfully',
            'information' => InternshipResource::make($internship)
        ]);
    }
}
