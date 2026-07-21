<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Student\AddStudentDTO;
use App\DTOs\Student\EditStudentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequests\AddStudentRequest;
use App\Http\Requests\StudentRequests\EditStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
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
            'information' => UserResource::make($val)
        ]);
    }

    #[Endpoint(title: 'Get Student info', description: 'The user that has a student role can get their user info with their student info')]
    public function getStudent()
    {
        $user = request()->user();

        return UserResource::make($this->studentService->getCompany($user));
    }
}
