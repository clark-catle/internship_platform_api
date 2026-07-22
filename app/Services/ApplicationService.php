<?php

namespace App\Services;

use App\Enum\File\FileCategoryEnum;
use App\Models\Internship;
use App\Models\Student;
use App\Repositories\ApplicationRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ApplicationService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private FileService $fileService,
        private StudentService $studentService,
        private ApplicationRepository $applicationRepo
    ) {}

    /**
     * checks first if the student already applied in the internship, if yes
     * it will throw an exception but if its a no it will proceed, now
     * if the passed `$file` is null, it will check if the `$student` has a 
     * resume, if not it will throw an error, but if there's a passed `$file`
     * then it will create it and store it, after that it will create an application 
     * @param ?UploadedFile $file
     * @param Student $student
     * @param Internship $internship
     */
    public function applyInternship(?UploadedFile $file, Student $student, Internship $internship)
    {
        return DB::transaction(function () use ($file, $student, $internship) {
            if ($this->applicationRepo->alreadyApplied($student->id, $internship->id))
                throw new ConflictHttpException('Student already applied in this internship.');

            if (!$file)
                $this->studentService->ensureResumeExist($student);

            $resume_id = $file ?
                $this->fileService->addFile($file, FileCategoryEnum::File)->id : $student->resume_id;

            $application = $this->applicationRepo->applyInternship($student->id, $resume_id, $internship->id);

            return $application->load(['internship', 'internship.company', 'internship.skill'])->refresh();
        });
    }
}
