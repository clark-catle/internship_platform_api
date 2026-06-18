<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['avatar_id', 'resume_id', 'user_id', 'course_id', 'school', 'region', 'city', 'cellphone_number'])]
class Student extends Model
{
    public function avatar()
    {
        return $this->belongsTo(File::class, 'avatar_id');
    }

    public function resume()
    {
        return $this->belongsTo(File::class, 'resume_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'student_skills');
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function report()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
