<?php

namespace App\Services;

use App\DTOs\Internship\AddInternshipDTO;
use App\DTOs\Internship\EditInternshipDTO;
use App\Jobs\InternshipJobs\InternshipForceDeleteMailJob;
use App\Models\Internship;
use App\Models\User;
use App\Repositories\ApplicationRepository;
use App\Repositories\InternshipRepository;
use Exception;
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
        private ApplicationRepository $applicationRepo
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

    public function viewInternship()
    {
        return $this->internshipRepo->viewInternship();
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
     * restore the soft deleted `$internship` and if the 
     * `$internship` has been deleted by the admin, it will abort
     * @param Internship $internship
     * @return bool
     */
    public function restoreInternship(Internship $internship)
    {
        return DB::transaction(function () use ($internship) {
            $this->ensureNotDeletedByAdmin($internship);

            $this->internshipRepo->restoreInternship($internship);
        });
    }

    public function forceRemove(Internship $internship, User $user)
    {
        $internship->load(['company.user']);

        DB::transaction(function () use ($internship, $user) {
            $this->adminDeleteInternship($internship, $user->id);

            $this->applicationRepo->rejectAllApplicationOfInternship($internship);
        });

        InternshipForceDeleteMailJob::dispatch($internship->company->user);
    }

    /**
     * deletes the `$internship` and mark the 
     * internship that it was deleted by an admin
     * @param Internship $internship
     * @param int $adminId
     * @return void
     */
    private function adminDeleteInternship(Internship $internship, int $adminId)
    {
        DB::transaction(function () use ($internship, $adminId) {
            $this->internshipRepo->deleteInternship($internship);

            $this->internshipRepo->adminDeleteInternship($internship, $adminId);
        });
    }

    /**
     * ensure that the `$intenship` wasn't deleted by an admin,
     * if it is, it will throw an exception
     * @param Internship $internship
     * @throws Exception
     * @return void
     */
    private function ensureNotDeletedByAdmin(Internship $internship)
    {
        if (filled($internship->admin_deleted_at))
            throw new Exception('The internship has been deleted by the admin and can\'t be restore!');
    }
}
