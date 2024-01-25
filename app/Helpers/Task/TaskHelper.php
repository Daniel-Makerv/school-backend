<?php

namespace App\Helpers\Task;

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

class TaskHelper
{
    /**
     * @param object $student
     * 
     * @return [type]
     */
    public static function TaskForStudent($student)
    {
        return Task::join('student_task_qualification', 'tasks.id', 'student_task_qualification.task_id')
            ->join('students', 'student_task_qualification.student_id', 'students.id')
            ->join('users', 'students.user_id', 'users.id')
            ->where(
                ['students.id' => $student->id],
                ['student_task_qualification.student_id' => $student->id],
            )->get();
    }
    public static function AllTasks()
    {
        return Task::selectRaw('tasks.name as name, tasks.description as description')->paginate(5);
    }

    public static function AllTasksWithStudents()
    {
        $roleStudent = Role::whereStr('student-role')->first();

        return Task::join('student_task_qualification', 'tasks.id', 'student_task_qualification.task_id')
            ->join('users', 'student_task_qualification.user_id', 'users.id')
            ->where([
                'users.role_id' => $roleStudent->id,
            ])->groupBy('tasks.id', 'users.id')
            ->selectRaw('task.name as taskName, task.description, COUNT(users.id) as students_assigned')
            ->paginate(5);
    }
}
