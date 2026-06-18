<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Student\AddStudentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequests\AddStudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(private StudentService $studentService) {}

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
}
