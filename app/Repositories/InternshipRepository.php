<?php

namespace App\Repositories;

use App\DTOs\Internship\AddInternshipDTO;
use App\Models\Company;
use App\Models\Internship;

class InternshipRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Internship $internship) {}

    /**
     * creates a new info of internship and its 
     * connected to `$company_id` and its data is 
     * based on the `$data` that was passed
     * @param AddInternshipDTO $data
     * @param int $company_id
     * @return Internship
     */
    public function addInternship(AddInternshipDTO $data, int $company_id)
    {
        return $this->internship->create([
            'title'         => $data->title,
            'description'   => $data->description,
            'requirements'  => $data->requirements,
            'region'        => $data->region,
            'city'          => $data->city,
            'setup'         => $data->setup,
            'allowance'     => $data->allowance,
            'duration'      => $data->duration,
            'duration_unit' => $data->duration_unit,
            'company_id'    => $company_id
        ]);
    }

    /**
     * edit the info of `$internship` base on the 
     * passed value of `$data`
     * @param Internship $internship
     * @param array $data
     * @return void
     */
    public function editInternship(Internship $internship, array $data)
    {
        $internship->update($data);
    }

    /**
     * soft deletes the `$internship` info
     * @param Internship $internship
     * @return void
     */
    public function deleteInternship(Internship $internship)
    {
        $internship->delete();
    }

    /**
     * soft deletes the `$internship` info
     * @param Internship $internship
     * @return void
     */
    public function restoreInternship(Internship $internship)
    {
        $internship->restore();
    }

    /**
     * return all the internship of the `$company` with its skills info
     * @return \Illuminate\Database\Eloquent\Collection<int, Internship>
     */
    public function companyInternship(Company $company)
    {
        return $company->internship()->with(['skill'])->get();
    }

    /**
     * return all of the internship with skills info
     * @return \Illuminate\Database\Eloquent\Collection<int, Internship>|\Illuminate\Support\Collection<int, \stdClass>
     */
    public function viewInternship()
    {
        return Internship::with(['skill', 'company'])->get();
    }

    /**
     * marks the `$internship` as deleted by the admin
     * @param Internship $internship
     * @param int $adminId
     * @return void
     */
    public function adminDeleteInternship(Internship $internship, int $adminId)
    {
        $internship->update(['admin_deleted_at' => now(), 'admin_deleted_by' => $adminId]);
    }

    /**
     * updates the is_active of the `$internship` base on the passed `$pendingPercentage`
     * @param Internship $internship
     * @param int $pendingPercentage
     * @return void
     */
    public function isActive(Internship $internship, int $pendingPercentage)
    {
        $internship->update([
            'is_active' => $pendingPercentage >= 20,
        ]);
    }
}
