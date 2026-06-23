<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enum\Internship\InternshipSetupEnum;
use App\Enum\Internship\InternshipAllowanceEnum;
use App\Enum\Internship\InternshipDurationUnitEnum;


#[Fillable(['title', 'description', 'requirements', 'region', 'city', 'setup', 'allowance', 'is_active', 'duration', 'duration_unit', 'company_id'])]
class Internship extends Model
{
    use SoftDeletes;

    public function casts(): array
    {
        return [
            'setup' => InternshipSetupEnum::class,
            'allowance' => InternshipAllowanceEnum::class,
            'is_active' => 'boolean',
            'duration' => 'int',
            'duration_unit' => InternshipDurationUnitEnum::class
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'internship_skills');
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }
}
