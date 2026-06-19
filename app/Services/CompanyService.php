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
            if ($this->companyRepo->companyExist($user))
                throw new ConflictHttpException('User already has a company profile.');

            $file = $this->fileService->addFile($data->logo, FileCategoryEnum::Image);

            $company = $this->companyRepo->addCompany(
                $data,
                $user->id,
                $file->id
            );

            return $company->load('user');
        });
    }

    /**
     * checks if the user has a company first then checks if theres a 
     * passed logo in `$data`, then if there is, it will store it in the
     * db and storage first then remove the old image later, but if theres
     * no passed logo, then it will just update the value of company
     * then it will return the company
     * @param EditCompanyDTO $data
     * @param User $user
     */
    public function editCompany(EditCompanyDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            if (!$this->companyRepo->companyExist($user))
                throw new ConflictHttpException('User doesn\'t have a company profile yet.');

            $newFile = $data->logo ?
                $newFile = $this->fileService->addFile($data->logo, FileCategoryEnum::Image) : null;

            $updatable = $data->toUpdatable($newFile?->id);

            $company = $user->company;

            $oldLogoId = $company->logo_id;

            $this->companyRepo->editCompany($company, $updatable);

            // removes the previous logo of company if theres a passed logo in the request
            if ($newFile)
                $this->fileService->removeFileById($oldLogoId);

            return $company->load('user');
        });
    }
}
