<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequests\ApplyInternshipRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Internship;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    public function __construct(
        private ApplicationService $applicationService
    ) {}

    public function applyInternship(ApplyInternshipRequest $request, Internship $internship)
    {
        $this->authorize('apply', Application::class);

        $student = request()->user()->student;

        $application = $this->applicationService->applyInternship($request->file('resume'), $student, $internship);

        return response()->json([
            'message' => 'Applied successfully!',
            'application' => ApplicationResource::make($application)
        ]);
    }
}
