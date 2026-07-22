<?php

namespace App\Policies;

use App\Enum\User\UserRoleEnum;
use App\Models\Application;
use App\Models\Internship;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\StudentRepository;

class ApplicationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    /**
     * checks if the `$user` already has a student info
     * @param User $user
     * @return bool
     */
    public function apply(User $user)
    {
        return $user->student()->exists();
    }

    /**
     * if the user is a student, it will check if the passed application owner is the user,
     * then if the user is a company, it will check if the posted internship owner in the 
     * application is the user, then will return false as a default
     * @param User $user
     * @param Application $application
     * @return bool
     */
    public function viewResumeApplication(User $user, Application $application)
    {
        switch ($user->role) {
            case UserRoleEnum::Student: //check if the passed application owner is the user
                if (!$user->student)
                    return false;

                return $user->student->id === $application->student_id;

            case UserRoleEnum::Company: // check if the posted internship in the application owner is the user
                if (!$user->company)
                    return false;

                return $user->company->id === $application->internship->company_id;

            default: // return false by default because there's nothing to check
                return false;
        }
    }
}
