<?php

namespace App\Models;

use App\Enum\Application\ApplicationProgressEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enum\Application\ApplicationStatusEnum;

#[Fillable(['applied_at', 'student_id', 'resume_id', 'internship_id'])]
class Application extends Model
{
    public function casts()
    {
        return [
            'status' => ApplicationStatusEnum::class,
            'progress' => ApplicationProgressEnum::class,
            'applied_at' => 'datetime'
        ];
    }

    public function resume()
    {
        return $this->belongsTo(File::class, 'resume_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
