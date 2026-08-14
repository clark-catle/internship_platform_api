<?php

namespace App\Repositories;

use App\Enum\Application\ApplicationProgressEnum;
use App\Enum\Application\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Student;

class ApplicationRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Application $application) {}

    /**
     * create an application info base on the 
     * passed parameters then returning it
     * @param int $student_id
     * @param int $resume_id
     * @param int $internship_id
     * @return Application
     */
    public function applyInternship(int $student_id, int $resume_id, int $internship_id)
    {
        return $this->application->create([
            'applied_at' => now(),
            'student_id' => $student_id,
            'resume_id' => $resume_id,
            'internship_id' => $internship_id
        ]);
    }

    /**
     * checks if there's an application that match with the `$student_id` and `$internship_id`
     * @param int $stundent_id
     * @param int $internship_id
     * @return bool
     */
    public function alreadyApplied(int $stundent_id, int $internship_id)
    {
        return Application::where('student_id', $stundent_id)
            ->where('internship_id', $internship_id)->exists();
    }

    /**
     * updates the status of `$application` base on the passed `$status`
     * @param Application $application
     * @param ApplicationStatusEnum $status
     * @return Application
     */
    public function updateApplicationStatus(Application $application, ApplicationStatusEnum $status)
    {
        $application->update(['status' => $status]);

        return $application;
    }

    /**
     * updates the progress of `$application` base on the passed `$progress`
     * @param Application $application
     * @param ApplicationProgressEnum $progress
     * @return Application
     */
    public function updateApplicationProgress(Application $application, ApplicationProgressEnum $progress)
    {
        $application->update(['progress' => $progress]);

        return $application;
    }

    /**
     * reject all the application of the passed `$internship` 
     * @param Internship $internship
     * @return void
     */
    public function rejectAllApplicationOfInternship(Internship $internship)
    {
        $this->application->where('internship_id', $internship->id)->update(['status' => ApplicationStatusEnum::Rejected->value]);
    }

    /**
     * retrieve all the application of the passed `$studentId`
     * @param int $studentId
     * @return \Illuminate\Database\Eloquent\Collection<int, Application>|\Illuminate\Support\Collection<int, \stdClass>
     */
    public function getAllStudentApplication(int $studentId)
    {
        return $this->application->where('student_id', $studentId)
            ->with(['internship.skill'])->get();
    }

    /**
     * retrieve all the application that was passed to the company
     * @param Company $company
     * @return \Illuminate\Database\Eloquent\Collection<int, Application>
     */
    public function getAllCompanyApplication(Company $company)
    {
        return $company->applications()->with([
            'student',
            'student.course',
            'student.skill',
            'internship',
            'internship.skill'
        ])->get();
    }

    /**
     * retrieve all the application info
     * @return \Illuminate\Database\Eloquent\Collection<int, Application>|\Illuminate\Support\Collection<int, \stdClass>
     */
    public function getAllApplication()
    {
        return $this->application->with([
            'student',
            'student.course',
            'student.skill',
            'internship',
            'internship.skill',
        ])->get();
    }

    /**
     * returns the overall count of the application
     * @return int
     */
    public function applicationCount()
    {
        return $this->application->count();
    }

    /**
     * return the count of the application that has a `$status` value
     * @param ApplicationStatusEnum $status
     * @return int
     */
    public function applicationsStatusCount(ApplicationStatusEnum $status)
    {
        return $this->application->where('status', $status)->count();
    }
}
