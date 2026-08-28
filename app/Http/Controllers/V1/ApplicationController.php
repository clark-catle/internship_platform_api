<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRequests\ApplyInternshipRequest;
use App\Http\Resources\ApplicationResource;
use App\Jobs\ApplicationJobs\NewApplyEmailJob;
use App\Models\Application;
use App\Models\Internship;
use App\Services\ApplicationService;
use App\Services\FileService;
use Dedoc\Scramble\Attributes\Endpoint;

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

    #[Endpoint(title: 'View all application', description: 'Student user can view their passed application, company can view the applications that was passed in thier internship post, while the admin can view all the application')]
    public function viewAllApplication()
    {
        $user = request()->user();

        $application = $this->applicationService->viewAllApplication($user);

        return ApplicationResource::collection($application);
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

    #[Endpoint(title: 'Interview Stage Application', description: 'The company user can interview the application, by first making sure the application isnt rejected and its progress is a applied to make sure the application inst interviewed yet, after this it will make the progress of the application into interview')]
    public function interviewApplication(Application $application)
    {
        $this->authorize('companyAccessApplication', $application);

        $this->applicationService->interviewApplication($application);

        return response()->json([
            'message' => 'Successfully moved the application into interview stage!',
            'application' => ApplicationResource::make($application)
        ]);
    }

    #[Endpoint(title: 'Decide Stage Application', description: 'The company user can mark the application as deciding stage by first making sure the application isnt rejected and its progress is a interview to make sure the application is already interviewed, after this it will make the progress of the application into decision')]
    public function decideApplication(Application $application)
    {
        $this->authorize('companyAccessApplication', $application);

        $this->applicationService->decideApplication($application);

        return response()->json([
            'message' => 'Successfully moved the application into decision stage!',
            'application' => ApplicationResource::make($application)
        ]);
    }

    #[Endpoint(title: 'Accept application', description: 'The company user can mark the application as accepted by first making sure the application isnt rejected and its progress is already in decision stage, after this it will make the status of the application into accepted')]
    public function acceptApplication(Application $application)
    {
        $this->authorize('companyAccessApplication', $application);

        $this->applicationService->acceptApplication($application);

        return response()->json([
            'message' => 'Application was accepted successfuly!',
            'application' => ApplicationResource::make($application)
        ]);
    }

    #[Endpoint(title: 'Reject application', description: 'The company user can mark the application as rejected by first making sure the application status isnt rejected yet and not accepted, after this it will make the status of the application into rejected')]
    public function rejectApplication(Application $application)
    {
        $this->authorize('companyAccessApplication', $application);

        $this->applicationService->rejectApplication($application);

        return response()->json([
            'message' => 'Application was rejected successfully!',
            'application' => ApplicationResource::make($application)
        ]);
    }

    #[Endpoint(title: 'Revert Rejected application', description: 'The company user can revert the rejected application by first making sure the application status isnt accepted, after this it will make the status of the application into in review')]
    public function revertRejectApplication(Application $application)
    {
        $this->authorize('companyAccessApplication', $application);

        $this->applicationService->revertRejectApplication($application);

        return response()->json([
            'message' => 'Application rejection has been reverted successfully!',
            'application' => ApplicationResource::make($application)
        ]);
    }
}
