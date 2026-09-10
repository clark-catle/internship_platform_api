<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Student\AddStudentDTO;
use App\DTOs\Student\EditStudentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequests\AddStudentRequest;
use App\Http\Requests\StudentRequests\EditStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
use App\Models\Student;
use App\Services\FileService;
use App\Services\StudentService;
use Dedoc\Scramble\Attributes\Endpoint;

class StudentController extends Controller
{
    public function __construct(
        private StudentService $studentService,
        private FileService $fileService
    ) {}

    #[Endpoint(title: 'Add Student info', description: 'The user that has a student role can add their student info')]
    public function addStudent(AddStudentRequest $request)
    {
        $val = AddStudentDTO::fromRequest($request);
        $user = $request->user();

        $val = $this->studentService->addStudent($val, $user);

        return response()->json([
            'message' => 'Student info has been created successfully',
            'information' => UserResource::make($val)
        ]);
    }

    #[Endpoint(title: 'Edit Student info', description: 'The user that has a student role can edit their student info')]
    public function editStudent(EditStudentRequest $request)
    {
        $val = EditStudentDTO::fromRequest($request);
        $user = $request->user();

        $val = $this->studentService->editStudent($val, $user);

        return response()->json([
            'message' => 'Student info has been updated successfully',
            'information' => StudentResource::make($val)
        ]);
    }

    #[Endpoint(title: 'Get Student info', description: 'The user that has a student role can get their user info with their student info, if there\'s no student info, it will only return empty array')]
    public function getStudent()
    {
        $user = request()->user();

        $student = $this->studentService->getCompany($user);

        if (!$student)
            return response()->json([]);

        return StudentResource::make($student);
    }


    #[Endpoint(title: 'View all student', description: 'The admin can view all student')]
    public function viewAllStudent()
    {
        $students = $this->studentService->viewAllStudent();

        return StudentResource::collection($students);
    }

    #[Endpoint(title: 'View student info', description: 'The admin can view specific student')]
    public function viewStudent(Student $student)
    {
        return StudentResource::make($student->load(['course', 'skill']));
    }

    #[Endpoint(title: 'View resume of student', description: 'The admin can view the resume of the student')]
    public function viewResumeOfStudent(Student $student)
    {
        return $this->fileService->getFile($student->resume);
    }
}
