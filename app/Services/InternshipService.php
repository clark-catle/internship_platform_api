<?php

namespace App\Services;

use App\DTOs\Internship\AddInternshipDTO;
use App\DTOs\Internship\EditInternshipDTO;
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
     * return all the internship
     * @return \Illuminate\Database\Eloquent\Collection<int, Internship>
     */
    public function companyInternship(User $user)
    {
        $this->companyService->ensureCompanyExist($user);

        return $this->internshipRepo->companyInternship($user->company);
    }

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
                $this->skillService->processIntershipSkill($internship, $data->skills_id, $data->other_skills);

            return $internship->load('skill');
        });
    }

    /**
     * updates the `$internship` info base on the `$data` then 
     * if theres a passed new
     * @param Internship $internship
     * @param EditInternshipDTO $data
     */
    public function editInternship(Internship $internship, EditInternshipDTO $data)
    {
        return DB::transaction(function () use ($internship, $data) {
            $this->internshipRepo->editInternship($internship, $data->toUpdatable());

            if (filled($data->skills_id) || filled($data->other_skills))
                $this->skillService->processIntershipSkill($internship, $data->skills_id, $data->other_skills);

            return $internship->load('skill');
        });
    }

    /**
     * soft deletes the `$internship`
     * @param Internship $internship
     * @return void
     */
    public function deleteInternship(Internship $internship)
    {
        DB::transaction(
            fn() => $this->internshipRepo->deleteInternship($internship)
        );
    }

    /**
     * restore the soft deleted `$internship`
     * @param Internship $internship
     * @return void
     */
    public function restoreInternship(Internship $internship)
    {
        DB::transaction(
            fn() => $this->internshipRepo->restoreInternship($internship)
        );
    }
}
