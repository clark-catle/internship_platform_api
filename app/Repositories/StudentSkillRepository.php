<?php

namespace App\Repositories;

use App\Models\Student;

class StudentSkillRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * sync the passed `$skills` to passed `$student` meaning
     * will remove an existing value in student skills but not pass in `$skills`,
     * will keep the existing value in student skill that is passed in `$skills`,
     * and creating a new value  for student skill if not existing yet
     * @param Student $student
     * @param array $skills
     */
    public function sync(Student $student, array $skills)
    {
        $student->skill()->sync($skills);
    }
}
