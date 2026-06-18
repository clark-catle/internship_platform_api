<?php

namespace App\Repositories;

use App\DTOs\File\AddFileDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileRepository
{
    public function __construct(private File $file) {}

    /**
     * storing the `$file` in private storage and its path
     * is based on the passed `$category` then storing it
     * in the database then returning it
     * @param UploadedFile $file
     * @param string $filename
     * @param FileCategoryEnum $category
     * @return File
     */
    public function createFile(UploadedFile $file, string $filename, FileCategoryEnum $category)
    {
        $path = $file->storeAs($category->value, $filename, 'private');

        return $this->file->create([
            'filename' => $filename,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'category' => $category,
            'size' => $file->getSize(),
        ]);
    }

    /**
     * getting the contents of file base on 
     * the path of `$file` then returning it
     * @param File $file
     * @return string|null
     */
    public function getFileContent(File $file)
    {
        return Storage::disk('private')->get($file->path);
    }

    /**
     * finds the file base on the passed $id` then returning it
     * @param int $id
     * @return File
     */
    public function getFileById(int $id)
    {
        return $this->file->find($id);
    }

    /**
     * removes the file in the private storage base on the passed `$file` 
     * @param File $file
     * @return void
     */
    public function removeStorageFile(File $file)
    {
        Storage::disk('private')->delete($file->path);
    }

    /**
     * removes the `$file` in the database
     * @param File $file
     * @return void
     */
    public function removeDBFile(File $file)
    {
        $file->delete();
    }
}
