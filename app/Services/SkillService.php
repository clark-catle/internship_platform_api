<?php

namespace App\Services;

use App\Models\Internship;
use App\Models\Student;
use App\Repositories\InternshipSkillRepository;
use App\Repositories\SkillRepository;
use App\Repositories\StudentSkillRepository;
use Illuminate\Support\Facades\DB;

class SkillService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private SkillRepository $skillRepo,
        private StudentSkillRepository $studentSkillRepo,
        private InternshipSkillRepository $internshipSkillRepo
    ) {}

    /**
     * returns immidiately if `$other_skills` is an empty array,
     * otherwise it will make a new skill base on the passed names
     * @param string[] $other_skills
     * @return void
     */
    private function insertOtherSkill(array $other_skills)
    {
        if (empty($other_skills))
            return;

        $this->skillRepo->insertNameOrIgnore($other_skills);
    }

    /**
     * creates a new skill record if theres a value pass in `$other_skills`
     * then merge it with the `$skill_ids` then pass it in sync function 
     * where it deletes the stored student skills that wasnt specified in 
     * `$skill_ids`, maintain the existing records that was specified in 
     * `$skill_ids`, and creates a new studentSkills that isnt existing yet
     * @param Student $student
     * @param int[] $skill_ids
     * @param string[] $other_skills
     * @return void
     */
    public function processStudentSkill(Student $student, array $skill_ids, array $other_skills)
    {
        DB::transaction(function () use ($student, $skill_ids, $other_skills) {
            $this->insertOtherSkill($other_skills);

            $new_skill = $this->skillRepo->getIdsByName($other_skills);

            $ids = array_unique(array_merge($new_skill, $skill_ids));

            $this->studentSkillRepo->sync($student, $ids);
        });
    }

    /**
     * creates a new skill record if theres a value pass in `$other_skills`
     * then merge it with the `$skill_ids` then pass it in sync function 
     * where it deletes the stored internship skills that wasnt specified in 
     * `$skill_ids`, maintain the existing records that was specified in 
     * `$skill_ids`, and creates a new internshipSkills that isnt existing yet
     * @param Internship $internship
     * @param int[] $skill_ids
     * @param string[] $other_skills
     * @return void
     */
    public function prcessIntershipSkill(Internship $internship, array $skill_ids, array $other_skills)
    {
        DB::transaction(function () use ($internship, $skill_ids, $other_skills) {
            $this->insertOtherSkill($other_skills);

            $new_skill = $this->skillRepo->getIdsByName($other_skills);

            $ids = array_unique(array_merge($new_skill, $skill_ids));

            $this->internshipSkillRepo->sync($internship, $ids);
        });
    }
}
