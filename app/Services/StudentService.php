<?php

namespace App\Services;

use App\DTOs\Student\AddStudentDTO;
use App\DTOs\Student\EditStudentDTO;
use App\Enum\File\FileCategoryEnum;
use App\Models\Student;
use App\Models\User;
use App\Repositories\StudentRepository;
use Exception;
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
        private SkillService $skillService
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
                $this->skillService->processStudentSkill($student, $data->skills_id, $data->other_skills);

            return $user->load(['student', 'student.course', 'student.skill']);
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

            if (filled($data->skills_id) || filled($data->other_skills))
                $this->skillService->processStudentSkill($student, $data->skills_id, $data->other_skills);

            return $student;
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
     * returns a student info base on the passed `$user`, if 
     * there's no student info, it will return null
     * @param User $user
     * @throws ConflictHttpException
     * @return Student | null
     */
    public function getStudent(User $user)
    {
        if (!$this->studentRepo->studentExist($user))
            return null;

        return $user->student;
    }

    /**
     * ensure that the `$student` has a resume, if not will throw an error
     * @param Student $student
     * @throws ConflictHttpException
     * @return void
     */
    public function ensureResumeExist(Student $student)
    {
        if (!$this->studentRepo->studentResumeExist($student))
            throw new ConflictHttpException('Student doesn\'t have a resume yet.');
    }

    /**
     * ensures that the `$user` has a student info, if it has
     * it will return a student, if not it will throw an exception
     * @param User $user
     * @throws Exception
     * @return Student
     */
    public function ensureStudentExist(User $user)
    {
        if (!$user->student()->exists())
            throw new Exception('The user doesn\'t have a student info yet!');

        $user->load(['student']);

        return $user->student;
    }

    /**
     * returns all the student info
     * @return \Illuminate\Database\Eloquent\Collection<int, Student>
     */
    public function viewAllStudent()
    {
        return $this->studentRepo->viewAllStudent();
    }

    /**
     * returns the `$user` resume by checking if the 
     * student info exists because that's where the 
     * resume id stored, then after that it checks if the 
     * resume of the student trully exists, after that check 
     * it will now get the file
     * @param User $user
     * @throws Exception
     * @throws ConflictHttpException
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function viewResume(User $user)
    {
        if (!$user->student()->exists())
            throw new Exception('You don\'t have a student info yet');

        $student = $user->student;

        if (!$this->studentRepo->studentResumeExist($student))
            throw new ConflictHttpException('Student doesn\'t have a resume yet.');

        return $this->fileService->getFile($student->resume);
    }
}
