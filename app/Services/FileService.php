<?php

namespace App\Services;

use App\DTOs\File\AddFileDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private FileRepository $fileRepo) {}

    /**
     * store the `$file` in the disk and creating a 
     * unique filename for it, creating a record for it
     * in database then returning it
     * @param UploadedFile $file
     * @return File
     */
    public function addImage(UploadedFile $file)
    {
        return DB::transaction(function () use ($file) {
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('image', $fileName, 'private');

            return $this->fileRepo->createFile(
                AddFileDTO::fromFile(
                    $file,
                    FileCategoryEnum::Image,
                    $path,
                    $fileName
                )
            );
        });
    }
}
