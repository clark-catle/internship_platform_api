<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;
use App\Repositories\CompanyRepository;

class InternshipPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(private CompanyRepository $companyRepo) {}

    /**
     * checks if the company exist and if the internship creator and the user is the same
     * @param User $user
     * @param Internship $internship
     * @return bool
     */
    public function modify(User $user, Internship $internship)
    {
        if (!$this->companyRepo->companyExist($user))
            return false;

        return $user->company->id === $internship->company_id;
    }
}
