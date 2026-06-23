<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Internship\AddInternshipDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipRequests\AddInternshipRequest;
use App\Http\Resources\InternshipResource;
use App\Services\InternshipService;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function __construct(private InternshipService $internshipService) {}

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
}
