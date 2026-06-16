<?php

namespace App\Services;

use App\DTOs\File\AddFileDTO;
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

    /**
     * retrieving the company logo base on the 
     * `$company` logo_id then returning a stream 
     * response, if theres nothing, will throw error instead
     * @param Company $company
     * @throws NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCompanyLogo(Company $company)
    {
        $file = $this->fileRepo->getFileById($company->logo_id);

        if (!$file)
            throw new NotFoundHttpException('Image not found.');

        $contents = $this->fileRepo->getFileContent($file);

        if (!$contents)
            throw new NotFoundHttpException('Image file not found in storage.');

        return response()->stream(function () use ($contents) {
            echo $contents;
        }, 200, [
            'Content-Type'  => $file->mime_type->value,
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }
}
