<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Skill extends Model
{
    use SoftDeletes;

    public function studentSkill()
    {
        return $this->hasMany(StudentSkill::class);
    }

    public function internshipSkill()
    {
        return $this->hasMany(InternshipSkill::class);
    }
}
