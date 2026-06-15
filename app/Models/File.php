<?php

namespace App\Models;

use App\Enum\File\FileCategoryEnum;
use App\Enum\File\FileMimeTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable(['filename', 'path', 'mime_type', 'size', 'category'])]
class File extends Model
{
    public function casts()
    {
        return [
            'mime_type' => FileMimeTypeEnum::class,
            'category' => FileCategoryEnum::class,
            'size' => 'int'
        ];
    }
}
