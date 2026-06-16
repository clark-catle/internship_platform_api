<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\FileService;

class FileController extends Controller
{
    public function __construct(private FileService $fileService) {}

    public function getCompanyLogo(Company $company)
    {
        return $this->fileService->getCompanyLogo($company);
    }
}
