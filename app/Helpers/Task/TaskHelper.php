<?php

namespace App\Helpers\Task;

use App\Helpers\Student\StudentHelper;
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
     * @param mixed $enrollment
     * @param mixed $taskId
     * 
     * @return [type]
     */
    public static function getQualificationTaskForStudent($enrollment, $taskId)
    {
        $student = StudentHelper::getOnlyStudent($enrollment);

        return Task::join('student_task', 'tasks.id', 'student_task.task_id')
            ->where([
                'student_task.task_id' => $taskId,
                'student_task.student_id' => $student->id
            ])->selectRaw('tasks.name as taskName, tasks.description as taskDescription, student_task.qualification as qualification')
            ->first();
    }

    /**
     * @param object $student
     * 
     * @return [type]
     */
    public static function TaskForStudent($student)
    {
        return Task::join('student_task', 'tasks.id', 'student_task.task_id')
            ->join('students', 'student_task.student_id', 'students.id')
            ->join('users', 'students.user_id', 'users.id')
            ->where([
                'students.id' => $student->id,
                'student_task.student_id' => $student->id,
            ])->get();
    }
    public static function AllTasks()
    {
        return Task::selectRaw('tasks.name as name, tasks.description as description')->paginate(5);
    }

    /**
     * @return [type]
     */
    public static function AllTasksWithStudents()
    {
        $roleStudent = Role::whereStr('student-role')->first();

        return Task::join('student_task', 'tasks.id', 'student_task.task_id')
            ->join('users', 'student_task.user_id', 'users.id')
            ->where([
                'users.role_id' => $roleStudent->id,
            ])->groupBy('tasks.id', 'users.id')
            ->selectRaw('task.name as taskName, task.description, COUNT(users.id) as students_assigned')
            ->paginate(5);
    }

    /**
     * @param mixed $enrollment
     * @param mixed $newQualification
     * @param mixed $task
     * 
     * @return [type]
     */
    public static function updateQualification($enrollment, $newQualification, $task)
    {
        try {
            $student = StudentHelper::getOnlyStudent($enrollment);
            $student->tasks()->updateExistingPivot($task->id, ['qualification' => $newQualification]);
        } catch (\Exception $err) {
            return throw new Exception("Error to updated qualification: " . $err->getMessage());
        }

        return self::getQualificationTaskForStudent($enrollment, $task->id);
    }

    /**
     * @param mixed $data
     * 
     * @return [type]
     */
    public static function storeTask($data)
    {
        try {
            $task = Task::create([
                'name' => $data->title,
                'description' => $data->description,
            ]);

            foreach ($data->students as $enrollment) {
                try {
                    $studentNotFound = [];
                    $student = StudentHelper::getOnlyStudent($enrollment);
                    $student->tasks()->attach($task->id, ['qualification' => $data->qualification ?? 0]);
                } catch (\Exception $err) {
                    $studentNotFound[] = $enrollment;
                }
            }
        } catch (\Exception $err) {
            return throw new Exception("Error to create task: " . $err->getMessage());
        }
        return (object)[
            'message' => "{$task->name} . create successfully",
            'studentNotFound' => $studentNotFound ?? null,
        ];
    }
}
