<?php

namespace App\Services;

use App\DTOs\Student\AddStudentDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\Student;
use App\Models\User;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private StudentRepository $studentRepo,
        private FileService $fileService
    ) {}

    /**
     * checks if the user already hasa student info, 
     * if not it will directly make a record for
     * a new student then returning it
     * @param AddStudentDTO $data
     * @param User $user
     * @return Student
     */
    public function addStudent(AddStudentDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            if ($this->studentRepo->studentExist($user))
                throw new ConflictHttpException('User already has a student profile.');

            $resume = $data->resume_file ?
                $this->fileService->addFile($data->resume_file, FileCategoryEnum::File) : null;
            $avatar = $data->avatar_image ?
                $this->fileService->addFile($data->avatar_image, FileCategoryEnum::Image) : null;

            $student = $this->studentRepo->addStudent($data, $user->id, $resume?->id, $avatar?->id);

            return $student->load(['user', 'course']);
        });
    }
}
