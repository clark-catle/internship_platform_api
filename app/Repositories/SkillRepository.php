<?php

namespace App\Repositories;

use App\Models\Skill;

class SkillRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Skill $skill) {}

    /**
     * insert a value in `$names` and if it exists
     * it will ignore it and proceed to other value
     * @param array $names 
     */
    public function insertNameOrIgnore(array $names)
    {
        Skill::insertOrIgnore(array_map(fn($name) => [
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now()
        ], $names));
    }

    /**
     * get the skills base on the passed `$names`
     * then returning only an array of id
     * @param array $names
     * @return array
     */
    public function getIdByName(array $names)
    {
        return Skill::whereIn('name', $names)->pluck('id')->toArray();
    }
}
