<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\FileService;
use Dedoc\Scramble\Attributes\Endpoint;

class FileController extends Controller
{
    public function __construct(private FileService $fileService) {}

    #[Endpoint(title: 'Get company logo', description: 'The user can request the logo of the company buy just passing the company id')]
    public function getCompanyLogo(Company $company)
    {
        return $this->fileService->getCompanyLogo($company);
    }
}
