<?php

namespace App\Services;

use App\DTOs\Internship\AddInternshipDTO;
use App\Models\Internship;
use App\Models\User;
use App\Repositories\InternshipRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class InternshipService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private CompanyService $companyService,
        private InternshipRepository $internshipRepo,
        private SkillService $skillService,
    ) {}

    /**
     * creates an internship info then returning it 
     * base on the passed value of `$data`
     * @param AddInternshipDTO $data
     * @param User $user
     * @return Internship
     */
    public function addInternship(AddInternshipDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $this->companyService->ensureCompanyExist($user);

            $company = $user->company;

            $internship = $this->internshipRepo->addInternship($data, $company->id);

            if (filled($data->skills_id) || filled($data->other_skills))
                $this->skillService->prcessIntershipSkill($internship, $data->skills_id, $data->other_skills);

            return $internship->setRelation('company', $company)->load('skill');
        });
    }
}
