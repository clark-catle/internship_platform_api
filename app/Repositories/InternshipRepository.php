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
}
