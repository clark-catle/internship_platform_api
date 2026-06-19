<?php

namespace App\Repositories;

use App\DTOs\Student\AddStudentDTO;
use App\Models\Student;
use App\Models\User;

class StudentRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Student $student) {}

    /**
     * checks if the `$user` has a student info
     * then returns a boolean result
     * @param User $user
     * @return bool
     */
    public function studentExist(User $user)
    {
        return $user->student()->exists();
    }

    /**
     * creating a new student base on the passed
     * parameter value then returning it
     * @param AddStudentDTO $data
     * @param mixed $resumeId
     * @param mixed $avatarId
     * @return Student
     */
    public function addStudent(AddStudentDTO $data, int $userId, ?int $resumeId, ?int $avatarId)
    {
        return $this->student->create([
            "region" => $data->region,
            "city" => $data->city,
            "cellphone_number" => $data->cellphone_number,
            "school" => $data->school,
            "course_id" => $data->course_id,
            "user_id" => $userId,
            "avatar_id" => $avatarId,
            "resume_id" => $resumeId,
        ]);
    }

    /**
     * updating the `$student` info base on the passed `$data`
     * @param Student $student
     * @param array $data
     * @return void
     */
    public function editStudent(Student $student, array $data)
    {
        $student->update($data);
    }
}
