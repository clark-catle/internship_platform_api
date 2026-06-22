<?php

namespace App\Services;

use App\Models\Student;
use App\Repositories\SkillRepository;
use App\Repositories\StudentSkillRepository;
use Illuminate\Support\Facades\DB;

class StudentSkillService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private SkillRepository $skillRepo,
        private StudentSkillRepository $studentSkillRepo
    ) {}

    /**
     * creates a student skill base on the passed `$skill_ids` and `$other_skills`,
     * by creating a new skill base on passed `$other_skills` if theres a valus passed
     * then merge both array to insert into studentSkill table
     * @param Student $student
     * @param array|null $skill_ids
     * @param array|null $other_skills
     * @return void
     */
    public function createStudentSkill(Student $student, ?array $skill_ids, ?array $other_skills)
    {
        DB::transaction(function () use ($student, $skill_ids, $other_skills) {
            if (filled($other_skills))
                $this->skillRepo->insertNameOrIgnore($other_skills);

            $new_skill = filled($other_skills) ?
                $this->skillRepo->getIdByName($other_skills) : null;

            $ids = array_unique(array_merge($new_skill ?? [], $skill_ids ?? []));

            $this->studentSkillRepo->sync($student, $ids);
        });
    }
}
