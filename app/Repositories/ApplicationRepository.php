<?php

namespace App\Repositories;

use App\Models\Application;

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
}
