<?php

namespace App\Services;

use App\Enum\File\FileCategoryEnum;
use App\Models\Company;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private FileRepository $fileRepo) {}

    /**
     * making a unique name for the `$file` then
     * storing it in private storage wether in file
     * or image path base on the passed `$category`
     * then creating a record in db then returning it
     * @param UploadedFile $file
     * @param FileCategoryEnum $category
     * @return File
     */
    public function addFile(UploadedFile $file, FileCategoryEnum $category)
    {
        return DB::transaction(function () use ($file, $category) {
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            return $this->fileRepo->createFile(
                $file,
                $fileName,
                $category
            );
        });
    }

    /**
     * retrieving the `$file` info in the storage then returning a stream response
     * @param File $file
     * @throws NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCompanyLogo(File $file)
    {
        $file_name = Str::ucfirst($file ? $file->category : 'file');

        if (!$file)
            throw new NotFoundHttpException("$file_name not found.");

        $contents = $this->fileRepo->getFileContent($file);

        if (!$file)
            throw new NotFoundHttpException("$file_name not found in storage.");

        return response()->stream(function () use ($contents) {
            echo $contents;
        }, 200, [
            'Content-Type'  => $file->mime_type->value,
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    /**
     * gets the file info first base on the passed `$fileId`
     * then removes the file info in both db and storage
     * @param string $fileId
     */
    public function removeFileById(string $fileId)
    {
        DB::transaction(function () use ($fileId) {
            $file = $this->fileRepo->getFileById($fileId);

            if (!$file)
                return;

            $this->fileRepo->removeDBFile($file);

            $this->fileRepo->removeStorageFile($file);
        });
    }
}
