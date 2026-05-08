<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Reason extends Model
{
    use SoftDeletes;

    public function reports()
    {
        return $this->belongsToMany(Report::class, 'report_reasons');
    }
}
