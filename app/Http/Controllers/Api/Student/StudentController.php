<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\Global\ResponseMessage;
use App\Helpers\Student\StudentHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $students = StudentHelper::getAllStudent();
        } catch (\Exception $err) {
            return ResponseMessage::msgClientError("upps error: " . $err->getMessage());
        }

        return response()->json([
            $students,
        ], 200);
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
    public function store(Student\Store $request)
    {
        try {
            $student = StudentHelper::storeStudent((object)$request->all());
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("upps error: " . $err->getMessage());
        }
        return ResponseMessage::msgSuccessStore("Student created successfully with enrollment: " . $student['student_enrollment']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $enrollment)
    {
        try {
            $student = StudentHelper::showStudent($enrollment);
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("upps error: " . $err->getMessage());
        }
        return response()->json($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $enrollment)
    {
        try {
            $student = StudentHelper::updateStudent($enrollment, $request->all());
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("upps error: " . $err->getMessage());
        }
        return response()->json([
            'success' => true,
            'data' => $request->all()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $enrollment)
    {
        try {
            $response = StudentHelper::deleteStudent($enrollment);
        } catch (\Exception $err) {
            return ResponseMessage::msgServerError("upps error: " . $err->getMessage());
        }
        return response()->json([
            'success' => true,
            'data' => $response,
        ], 200);
    }
}
