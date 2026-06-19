<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Student\AddStudentDTO;
use App\DTOs\Student\EditStudentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequests\AddStudentRequest;
use App\Http\Requests\StudentRequests\EditStudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;
use Dedoc\Scramble\Attributes\Endpoint;

class StudentController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    #[Endpoint(title: 'Add Student info', description: 'The user that has a student role can add their student info')]
    public function addStudent(AddStudentRequest $request)
    {
        $val = AddStudentDTO::fromRequest($request);
        $user = $request->user();

        $student = $this->studentService->addStudent($val, $user);

        return response()->json([
            'message' => 'Student info has been created successfully',
            'information' => StudentResource::make($student)
        ]);
    }

    #[Endpoint(title: 'Edit Student info', description: 'The user that has a student role can edit their student info')]
    public function editStudent(EditStudentRequest $request)
    {
        $val = EditStudentDTO::fromRequest($request);
        $user = $request->user();

        $student = $this->studentService->editStudent($val, $user);

        return response()->json([
            'message' => 'Student info has been updated successfully',
            'information' => StudentResource::make($student)
        ]);
    }
}
