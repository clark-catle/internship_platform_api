<?php

namespace App\Services;

use App\DTOs\Company\AddCompanyDTO;
use App\DTOs\Company\EditCompanyDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\User;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyService
{

    public function __construct(
        private CompanyRepository $companyRepo,
        private FileService $fileService,
        private UserRepository $userRepo
    ) {}

    /**
     * throws an exception if the `$user` doesnt have
     * a company info in company table
     * @param User $user
     * @throws ConflictHttpException
     * @return void
     */
    public function ensureCompanyExist(User $user): void
    {
        if (!$this->companyRepo->companyExist($user))
            throw new ConflictHttpException('User doesn\'t have a company profile yet.');
    }

    /**
     * throws an exception if the `$user` already has
     * a company info in company table
     * @param User $user
     * @throws ConflictHttpException
     * @return void
     */
    public function ensureCompanyDoesntExist(User $user): void
    {
        if ($this->companyRepo->companyExist($user))
            throw new ConflictHttpException('User already has a company profile.');
    }

    /**
     * recieveing `$data` and `$user` then passing it into repository for
     * company creation base on `$user` and `$data` info
     * @param AddCompanyDTO $data
     * @param User $user
     */
    public function addCompany(AddCompanyDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $this->ensureCompanyDoesntExist($user);

            $file = $this->fileService->addFile($data->logo, FileCategoryEnum::Image);

            $this->companyRepo->addCompany(
                $data,
                $user->id,
                $file->id
            );

            return $user->load('company');
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
            $this->ensureCompanyExist($user);

            $newFile = $data->logo ?
                $newFile = $this->fileService->addFile($data->logo, FileCategoryEnum::Image) : null;

            $updatable = $data->toUpdatable($newFile?->id);

            $company = $user->company;

            $oldLogoId = $company->logo_id;

            $this->companyRepo->editCompany($company, $updatable);

            // removes the previous logo of company if theres a passed logo in the request
            if ($newFile)
                $this->fileService->removeFileById($oldLogoId);

            return $user->load('company');
        });
    }

    /**
     * returns a company info base on the passed `$user`
     * @param User $user
     * @throws ConflictHttpException
     * @return User|null
     */
    public function getCompany(User $user)
    {
        $this->ensureCompanyExist($user);

        return $user->load('company');
    }

    /**
     * return the logo of the company `$user` by checking first if the user has a company info
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getLogo(User $user)
    {
        $this->ensureCompanyExist($user);

        return $this->fileService->getFile($user->company->logo);
    }

    /**
     * return all the company user that is a company role
     * @return \Illuminate\Database\Eloquent\Collection<int, User>|\Illuminate\Support\Collection<int, \stdClass>
     */
    public function getAllCompany()
    {
        return $this->companyRepo->getAllCompany();
    }
}
