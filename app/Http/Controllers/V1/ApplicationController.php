<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequests\ApplyInternshipRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Internship;
use App\Services\ApplicationService;
use App\Services\FileService;
use Dedoc\Scramble\Attributes\Endpoint;
use Illuminate\Http\Request;
use Laravel\Boost\Install\ThirdPartyPackage;

/**
 * @tags Application
 */
class ApplicationController extends Controller
{

    public function __construct(
        private ApplicationService $applicationService,
        private FileService $fileService
    ) {}

    #[Endpoint(title: 'Student Apply', description: 'The user that is a student can apply to an internship once. The user can either pass a specific resume or not, if there\'s no passed resume, it will used its stored resume of student')]
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

    #[Endpoint(title: 'View internship application', description: 'The user can view the application, if the user is a student, it can only see its own application, but if the user is a company, it can only see its only see the application that was connected to its posted internship and the application that was seen, its status will be updated into in review')]
    public function viewApplication(Application $application)
    {
        $this->authorize('viewResumeApplication', $application);

        $application = $this->applicationService->viewApplication($application, request()->user()->role);

        return ApplicationResource::make($application);
    }

    #[Endpoint(title: 'View resume of internship application', description: 'The user can view the resume of the application, if the user is student, its validate where it can only access the applied internship of the student, then if the user is a company, its validated by checking if the posted internship owner of the application is the company')]
    public function viewApplicationResume(Application $application)
    {
        $this->authorize('viewResumeApplication', $application);

        return $this->fileService->getFile($application->resume);
    }
}
