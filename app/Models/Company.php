<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['company_name', 'company_logo_path', 'description', 'region', 'city', 'website', 'is_verified', 'user_id'])]
class Company extends Model
{

    public function casts(): array
    {
        return [
            'is_verified' => 'boolean'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function internship()
    {
        return $this->hasMany(Internship::class);
    }

    public function report()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
