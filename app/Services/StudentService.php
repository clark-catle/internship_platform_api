<?php

namespace App\Services;

use App\DTOs\Student\AddStudentDTO;
use App\DTOs\Student\EditStudentDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\Student;
use App\Models\User;
use App\Repositories\StudentRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use \App\Models\File;
use App\Repositories\StudentSkillRepository;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private StudentRepository $studentRepo,
        private FileService $fileService,
        private StudentSkillRepository $studentSkillRepo,
        private StudentSkillService $studentSkillService
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

            $file = $this->processStudentFile($data->resume_file, $data->avatar_image);

            $student = $this->studentRepo->addStudent(
                $data,
                $user->id,
                $file["resume"]?->id,
                $file["avatar"]?->id
            );

            if (filled($data->skills_id) || filled($data->other_skills))
                $this->studentSkillService->createStudentSkill($student, $data->skills_id, $data->other_skills);

            return $student->load(['user', 'course', 'skill']);
        });
    }

    /**
     * process the files of the student if theres a file
     * passed in `$data` then updates the student info
     * base also in the passed `$data`. if theres a passed 
     * new avatar file, it will remove the previous avatar
     * file, the resume wasnt deleted because the previous 
     * application was connected to that resume
     * @param EditStudentDTO $data
     * @param User $user
     */
    public function editStudent(EditStudentDTO $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {
            if (!$this->studentRepo->studentExist($user))
                throw new ConflictHttpException('User doesn\'t have a student profile yet.');

            $file = $this->processStudentFile($data->resume_file, $data->avatar_image);

            $updatable = $data->toUpdatable(
                $file["avatar"]?->id,
                $file["resume"]?->id
            );

            $student = $user->student;

            $oldAvatarId = $student->avatar_id;

            $this->studentRepo->editStudent($student, $updatable);

            if ($file["avatar"])
                $this->fileService->removeFileById($oldAvatarId);

            return $student->load('user');
        });
    }

    /**
     * takes `$resume_file` and `$avatar_image` to process it
     * by inserting it in db and storage if the passed
     * parameter is not null, then returns a result
     * @param UploadedFile|null $resume_file
     * @param UploadedFile|null $avatar_image
     * @return array{avatar: File|null, resume: File|null}
     */
    private function processStudentFile(?UploadedFile $resume_file, ?UploadedFile $avatar_image)
    {
        $resume = $resume_file ?
            $this->fileService->addFile($resume_file, FileCategoryEnum::File) : null;
        $avatar = $avatar_image ?
            $this->fileService->addFile($avatar_image, FileCategoryEnum::Image) : null;

        return [
            "resume" => $resume,
            "avatar" => $avatar
        ];
    }

    /**
     * returns a student info base on the passed `$user`
     * @param User $user
     * @throws ConflictHttpException
     * @return Student
     */
    public function getCompany(User $user)
    {
        if (!$this->studentRepo->studentExist($user))
            throw new ConflictHttpException('User doesn\'t have a student profile yet.');

        return $user->student->setRelation('user', $user);
    }
}
