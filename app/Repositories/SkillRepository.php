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
     * if `$names` is an empty array, it will return an empty 
     * array, on the other hand, get the skills base on the 
     * passed `$names` then returning only an array of id
     * @param array $names
     * @return array
     */
    public function getIdsByName(array $names)
    {
        if (empty($names)) return [];

        return Skill::whereIn('name', $names)->pluck('id')->toArray();
    }
}
