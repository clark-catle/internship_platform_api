<?php

namespace App\DTOs\File;

use App\Enum\File\FileCategoryEnum;
use App\Enum\File\FileMimeTypeEnum;
use Illuminate\Http\UploadedFile;

class AddFileDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $filename,
        public readonly FileMimeTypeEnum $mime_type,
        public readonly int $size,
        public readonly FileCategoryEnum $category,
    ) {}

    public static function fromFile(
        UploadedFile $file,
        FileCategoryEnum $category,
        string $filename
    ) {
        return new self(
            filename: $filename,
            mime_type: FileMimeTypeEnum::from($file->getMimeType()),
            size: $file->getSize(),
            category: $category,
        );
    }
}
