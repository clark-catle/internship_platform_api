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
        public readonly string $path,
        public readonly FileMimeTypeEnum $mime_type,
        public readonly int $size,
        public readonly FileCategoryEnum $category,
    ) {}

    public static function fromFile(
        UploadedFile $file,
        FileCategoryEnum $category,
        string $path,
        string $filename
    ) {
        return new self(
            filename: $filename,
            path: $path,
            mime_type: FileMimeTypeEnum::from($file->getMimeType()),
            size: $file->getSize(),
            category: $category,
        );
    }
}
