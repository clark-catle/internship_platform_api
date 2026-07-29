<?php

namespace App\Services;

use App\Enum\Application\ApplicationProgressEnum;
use App\Enum\Application\ApplicationStatusEnum;
use App\Enum\File\FileCategoryEnum;
use App\Enum\User\UserRoleEnum;
use App\Models\Application;
use App\Models\Internship;
use App\Models\Student;
use App\Repositories\ApplicationRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ApplicationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private FileService $fileService,
        private StudentService $studentService,
        private ApplicationRepository $applicationRepo
    ) {}

    /**
     * checks first if the student already applied in the internship, if yes
     * it will throw an exception but if its a no it will proceed, now
     * if the passed `$file` is null, it will check if the `$student` has a 
     * resume, if not it will throw an error, but if there's a passed `$file`
     * then it will create it and store it, after that it will create an application 
     * @param ?UploadedFile $file
     * @param Student $student
     * @param Internship $internship
     */
    public function applyInternship(?UploadedFile $file, Student $student, Internship $internship)
    {
        return DB::transaction(function () use ($file, $student, $internship) {
            if ($this->applicationRepo->alreadyApplied($student->id, $internship->id))
                throw new ConflictHttpException('Student already applied in this internship.');

            if (!$file)
                $this->studentService->ensureResumeExist($student);

            $resume_id = $file ?
                $this->fileService->addFile($file, FileCategoryEnum::File)->id : $student->resume_id;

            $application = $this->applicationRepo->applyInternship($student->id, $resume_id, $internship->id);

            return $application->load(['internship', 'internship.company', 'internship.skill'])->refresh();
        });
    }

    /**
     * ready and load the needed `$application` info base on the `$role` that was passed, 
     * if the `$role` is company, it will update the status of the application into in review
     * @param Application $application
     * @param UserRoleEnum $role
     * @return Application|null
     */
    public function viewApplication(Application $application, UserRoleEnum $role)
    {
        switch ($role) {
            case UserRoleEnum::Student:
                return $application->load([
                    'internship',
                    'internship.skill',
                    'internship.company'
                ]);

            case UserRoleEnum::Company:
                return $this->companyViewApplication($application);

            case UserRoleEnum::Admin:
                return $application->load([
                    'student',
                    'student.course',
                    'student.skill',
                    'internship',
                    'internship.skill',
                    'internship.company'
                ]);

            default:
                return null;
        }
    }

    /**
     * checks if the `$application` status is pending, if it is, it will be updated 
     * into in review then returning the applicatio together with the loaded info
     * @param Application $application
     * @throws Exception
     */
    private function companyViewApplication(Application $application)
    {
        return DB::transaction(function () use ($application) {
            if ($application->status === ApplicationStatusEnum::Pending)
                $this->applicationRepo->updateApplicationStatus($application, ApplicationStatusEnum::InReview);

            return $application->load([
                'student',
                'student.course',
                'student.skill',
                'internship',
                'internship.skill'
            ]);
        });
    }

    /**
     * ensures that the `$application` isnt rejected, if rejected will throw an error
     * @param Application $application
     * @throws Exception
     * @return void
     */
    private function ensureApplicationNotRejected(Application $application)
    {
        if ($application->status === ApplicationStatusEnum::Rejected)
            throw new Exception('Application already rejeted!');
    }

    /**
     * Interview the `$application` by checking first if the application isn't rejected
     * and if its not equals applied progress then it means its alread accepted,
     * after all of its checks, it makes its progress into interview
     * @param Application $application
     * @throws Exception
     * @return Application
     */
    public function interviewApplication(Application $application)
    {
        $this->ensureApplicationNotRejected($application);

        // ensure the progress is "applied" to proceed
        if ($application->progress === ApplicationProgressEnum::Interview)
            throw new Exception('The application has already been advanced to the interview stage!');
        else if ($application->progress === ApplicationProgressEnum::Decision)
            throw new Exception('The application interview is already completed!');

        $this->applicationRepo->updateApplicationProgress($application, ApplicationProgressEnum::Interview);

        return $application->load([
            'student',
            'student.course',
            'student.skill',
            'internship',
            'internship.skill'
        ]);
    }

    /**
     * make the `$application` progress into decision by checking first 
     * that the application isnt rejected and making sure the current
     * progress of the `$application` is interview
     * @param Application $application
     * @throws Exception
     * @return Application
     */
    public function decideApplication(Application $application)
    {
        $this->ensureApplicationNotRejected($application);

        // ensure the progress is "interview" to proceed
        if ($application->progress === ApplicationProgressEnum::Applied)
            throw new Exception('The application should complete interview stage first!');
        else if ($application->progress === ApplicationProgressEnum::Decision)
            throw new Exception('The application is already in the final decision stage!');

        $this->applicationRepo->updateApplicationProgress($application, ApplicationProgressEnum::Decision);

        return $application->load([
            'student',
            'student.course',
            'student.skill',
            'internship',
            'internship.skill'
        ]);
    }

    /**
     * accept the `$application` by checking if its not rejected and 
     * its progress is decision, after the checks it will proceed with
     * the change of the `$application` status into accepted
     * @param Application $application
     * @throws Exception
     * @return Application
     */
    public function acceptApplication(Application $application)
    {
        $this->ensureApplicationNotRejected($application);

        if ($application->progress !== ApplicationProgressEnum::Decision)
            throw new Exception('The application must be in the decision stage before it can be marked as accepted!');

        if ($application->status === ApplicationStatusEnum::Accepted)
            throw new Exception('The application has been already accepted!');

        $this->applicationRepo->updateApplicationStatus($application, ApplicationStatusEnum::Accepted);

        return $application->load([
            'student',
            'student.course',
            'student.skill',
            'internship',
            'internship.skill'
        ]);
    }

    // another function for reconsideration where it will remove the reject just to proceed to the next stage
}
