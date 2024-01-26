<?php

namespace App\Helpers\Student;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Role;
use App\Models\Seller;
use App\Models\Status;
use App\Models\Student;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class StudentHelper
{

    /**
     * @param mixed $user
     * generate enrollment for student
     * @return [type]
     */
    public static function generateEnrollment($user)
    {

        return config('app.identify_school_id') . $user->id;
    }

    public static function getOnlyStudent($enrollment)
    {
        return Student::whereStudentEnrollment($enrollment)->firstOr(function () {
            throw new ModelNotFoundException('student not found', 404);
        });
    }
    /**
     * @param mixed $enrollment
     * 
     * @return [type]
     */
    public static function getStudent($enrollment)
    {
        $student = Student::whereStudentEnrollment($enrollment)->firstOr(function () {
            throw new ModelNotFoundException('student not found', 404);
        });

        return User::join('students', 'users.id', 'students.user_id')
            ->where([
                'users.id' => $student->user_id
            ])->selectRaw('users.name as name, users.email as email, users.created_at as created_at, users.updated_at as updated_at, 
        users.birthdate as birthdate, users.age as age, students.student_enrollment as student_enrollment, students.comment_description as comment_description')
            ->first();
    }

    /**
     * @return [type]
     */
    public static function getAllStudent()
    {
        try {
            $roleStudent = Role::whereStr('student-role')->first();
            $users = User::join('students', 'users.id', 'students.user_id')
                ->join('statuses', 'users.status_id', 'statuses.id')
                ->where([
                    'users.role_id' => $roleStudent->id
                ])
                ->selectRaw('users.name as name, users.email as email, users.created_at as created_at, users.updated_at as updated_at, users.birthdate as birth_date, users.age as age, statuses.name as status, 
                students.student_enrollment as enrollment, students.comment_description as comment_description')
                ->paginate(5);
        } catch (\Exception $err) {
            return throw new Exception("Error to get students" . $err->getMessage(), 500);
        }

        return $users;
    }

    /**
     * @param mixed $data
     * 
     * @return [type]
     */
    public static function storeStudent($data)
    {
        try {
            $statusUserActive = Status::whereStr('status-active-user')->first();
            $roleStudent = Role::whereStr('student-role')->first();

            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'status_id' => $statusUserActive->id,
                'role_id' => $roleStudent->id,
                'birthdate' => $data->birthdate,
                'age' => random_int(18, 25),
            ]);

            $studentData = [
                'student_enrollment' => self::generateEnrollment($user),
                'comment_description' => $data->comment,
            ];

            $student = $user->student()->create($studentData);
        } catch (\Exception $err) {
            return throw new Exception("Error to create student: " . $err->getMessage(), 500);
        }

        return $studentData;
    }

    /**
     * @param mixed $enrollment
     * 
     * @return [type]
     */
    public static function showStudent($enrollment)
    {
        try {
            $student = self::getStudent($enrollment);
        } catch (\Exception $err) {
            return throw new Exception("Error to get student: " . $err->getMessage(), 500);
        }

        return $student;
    }

    /**
     * @param mixed $enrollment
     * @param mixed $data
     * 
     * @return [type]
     */
    public static function updateStudent($enrollment, $data)
    {
        try {
            $student = Student::whereStudentEnrollment($enrollment)->firstOr(function () {
                throw new ModelNotFoundException('student not found', 404);
            });
            $user = User::find($student->user_id);
            return json_encode($data);
            $student->update($data);
            $user->update($data);
        } catch (\Exception $err) {
            return throw new Exception("Error to update student: " . $err->getMessage(), 500);
        }
        return $student;
    }

    /**
     * @param mixed $enrollment
     * 
     * @return [type]
     */
    public static function deleteStudent($enrollment)
    {
        try {
            $student = Student::whereStudentEnrollment($enrollment)->firstOr(function () {
                throw new ModelNotFoundException('student not found', 404);
            });

            //delete task for student
            $user = User::find($student->user_id);
            $student->tasks()->detach();
            $student->delete();
            $user->delete();
        } catch (\Exception $err) {
            return throw new Exception("Error to delete student: " . $err->getMessage(), 500);
        }

        return "student delete successfully with enrollment: " . $enrollment;
    }

    /**
     * @param mixed $enrollment
     * 
     * @return [type]
     */
    public static function TasksForStudent($enrollment)
    {
        try {
            $student = Student::whereStudentEnrollment($enrollment)->firstOr(function () {
                throw new ModelNotFoundException('student not found', 404);
            });

            $tasks = Task::join('student_task', 'tasks.id', 'student_task.task_id')
                ->join('students', 'student_task.student_id', 'students.id')
                ->where([
                    'students.user_id' => $student->user_id
                ])->selectRaw('tasks.name as taskName, tasks.description as taskDescription, student_task.qualification as qualification')->get();
        } catch (\Exception $err) {
            return throw new Exception("Error to get task for student: " . $err->getMessage(), 404);
        }
        return $tasks;
    }
}
