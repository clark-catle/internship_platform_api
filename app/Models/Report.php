<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enum\Report\ReportStatusEnum;

#[Fillable(['description', 'status', 'admin_notes', 'read_at'])]
class Report extends Model
{
    public function casts()
    {
        return [
            'status' => ReportStatusEnum::class,
            'read_at' => 'datetime'
        ];
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }

    public function reportable()
    {
        return $this->morphTo();
    }

    public function reasons()
    {
        return $this->belongsToMany(Reason::class, 'report_reasons');
    }
}
