<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enum\Application\ApplicationStatusEnum;

#[Fillable(['status', 'applied_at'])]
class Application extends Model
{
    public function casts()
    {
        return [
            'status' => ApplicationStatusEnum::class,
            'applied_at' => 'datetime'
        ];
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
