<?php

namespace App\Services;

use App\DTOs\Company\AddCompanyDTO;
use App\DTOs\Company\EditCompanyDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CompanyService
{

    public function __construct(
        private CompanyRepository $companyRepo,
        private FileService $fileService
    ) {}

    /**
     * recieveing `$data` and `$user` then passing it into repository for
     * company creation base on `$user` and `$data` info
     * @param AddCompanyDTO $data
     * @param User $user
     */
    public function addCompany(AddCompanyDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $exists = $this->companyRepo->companyExist($user);

            if ($exists)
                throw new ConflictHttpException('User already has a company profile.');

            $file = $this->fileService->addFile($data->logo, FileCategoryEnum::Image);

            $company = $this->companyRepo->addCompany(
                $data,
                $user->id,
                $file->id
            );

            $company->load('logo');

            return $company;
        });
    }

    public function editCompany(EditCompanyDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            if (filled($data->logo))
                dd();
        });
    }
}
