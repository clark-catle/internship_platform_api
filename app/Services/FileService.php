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
     * retrieving the company logo base on the 
     * info of `$company` then returning it
     * @param Company $company
     * @throws NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCompanyLogo(Company $company)
    {
        $logo = $company->logo;

        if (!$logo)
            throw new NotFoundHttpException('Image not found.');

        $contents = $this->fileRepo->getFileContent($logo);

        if (!$contents)
            throw new NotFoundHttpException('Image file not found in storage.');

        return response()->stream(function () use ($contents) {
            echo $contents;
        }, 200, [
            'Content-Type'  => $logo->mime_type->value,
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    public function removeFile(File $file, UploadedFile $newFile)
    {
        return DB::transaction(function () use ($file, $newFile) {
            $file->delete();
        });
    }
}
