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
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function __construct(private InternshipService $internshipService) {}

    #[Endpoint(title: 'Create internship', description: 'The user that has a company role can create their own internship info')]
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

    #[Endpoint(title: 'Edit internship', description: 'The user that has a company role can edit their own internship info and not other\'s internship')]
    public function editInternship(EditInternshipRequest $request, Internship $internship)
    {
        $this->authorize('modify', $internship);

        $data = EditInternshipDTO::fromRequest($request);

        $internship = $this->internshipService->editInternship($internship, $data);

        return response()->json([
            'message' => 'Internship has been updated successfully',
            'information' => InternshipResource::make($internship)
        ]);
    }

    #[Endpoint(title: 'Delete internship', description: 'The user that has a company role can delete their own internship info and not other\'s internship')]
    public function deleteInternship(Internship $internship)
    {
        $this->authorize('modify', $internship);

        $this->internshipService->deleteInternship($internship);

        return response()->json([
            'message' => 'Internship has been deleted successfully',
        ]);
    }

    #[Endpoint(title: 'Restore internship', description: 'The user that has a company role can restore their own internship that has been deleted not other\'s internship')]
    public function restoreInternship(Internship $internship)
    {
        $this->authorize('modify', $internship);

        $this->internshipService->restoreInternship($internship);

        return response()->json([
            'message' => 'Internship has been deleted successfully',
            'information' => InternshipResource::make($internship)
        ]);
    }
}
