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
     * creates a new skill record if theres a value pass in `$other_skills`
     * then merge it with the `$skill_ids` then pass it in sync function 
     * where it deletes the stored student skills that wasnt specified in 
     * `$skill_ids`, maintain the existing records that was specified in 
     * `$skill_ids`, and creates a new studentSkills that isnt existing yet
     * @param Student $student
     * @param array $skill_ids
     * @param array $other_skills
     * @return void
     */
    public function processStudentSkill(Student $student, ?array $skill_ids, ?array $other_skills)
    {
        DB::transaction(function () use ($student, $skill_ids, $other_skills) {
            if (filled($other_skills))
                $this->skillRepo->insertNameOrIgnore($other_skills);

            $new_skill = filled($other_skills) ?
                $this->skillRepo->getIdByName($other_skills) : null;

            $ids = array_unique(array_merge($new_skill, $skill_ids));

            $this->studentSkillRepo->sync($student, $ids);
        });
    }
}
