<?php

namespace App\Repositories;

use App\Models\Internship;

class InternshipSkillRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * sync the passed `$skills` to passed `$internship` meaning
     * will remove an existing value in internship skills but not pass in `$skills`,
     * will keep the existing value in internship skill that is passed in `$skills`,
     * and creating a new value  for internship skill if not existing yet
     * @param Internship $internship
     * @param array $skills
     */
    public function sync(Internship $internship, array $skills)
    {
        $internship->skill()->sync($skills);
    }
}
