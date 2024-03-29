<?php

namespace App\Http\Controllers\Api\Task;

use App\Helpers\Task\TaskHelper;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task as TaskRequest;
use App\Helpers\Global\ResponseMessage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskRequest\Get $request)
    {
        try {
            match ($request->total_students) {
                true => $task = TaskHelper::AllTasksWithStudents(),
                false => $task = TaskHelper::AllTasks(),
                default => $task = TaskHelper::AllTasks(),
            };
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("Error to get tasks " . $err->getMessage());
        }
        return response()->json($task);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest\Store $request)
    {
        try {
            $response = TaskHelper::storeTask((object)$request->all());
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("Error to create task: " . $err->getMessage());
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest\Update $request, Task $task)
    {
        try {
            $response = TaskHelper::updateQualification($request->enrollment, $request->qualification, $task);
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("Error to updated qualification: " . $err->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Updated Qualification',
            'data' => $response
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
