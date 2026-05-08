<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enum\Internship\InternshipSetupEnum;
use App\Enum\Internship\InternshipAllowanceEnum;

#[Fillable(['title', 'description', 'requirements', 'region', 'city', 'setup', 'allowance', 'is_active'])]
class Internship extends Model
{
    use SoftDeletes;

    public function casts(): array
    {
        return [
            'setup' => InternshipSetupEnum::class,
            'allowance' => InternshipAllowanceEnum::class,
            'is_active' => 'boolean'
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function internshipSkill()
    {
        return $this->belongsToMany(Skill::class, 'internship_skills');
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }
}
