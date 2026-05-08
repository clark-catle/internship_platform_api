<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Course extends Model
{
    use SoftDeletes;

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
