<?php

namespace App\Helpers\Student;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Role;
use App\Models\Seller;
use App\Models\Status;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Exception;
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
}
