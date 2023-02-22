<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function all_accepted_students()
    {
        $students = Student::with('last_name')->where('is_approved', 1)->get(['id', 'first_name', 'image']);
        return response([
            $students
        ]);
    }

    public function all_pending_students()
    {
        $students = Student::with('last_name')->where('is_approved', 0)->get(['id', 'first_name', 'image']);
        return response([
            $students
        ]);
    }

    public function show($student_id)
    {
        $student = Student::with('last_name')->find($student_id);
        if (!$student?->is_approved) {
            return response([
                'message' => 'Student not found'
            ]);
        }
        return response([
            $student
        ]);
    }

    public function father_accepted_students()
    {
        $father = auth()->user()->father;
        $students = $father->students()->where('is_approved', 1)->get(['first_name', 'image']);
        return $students;
    }

    public function father_pending_students()
    {
        $father = auth()->user()->father;
        $students = $father->students()->where('is_approved', 0)->get(['first_name', 'image']);
        return $students;
    }


    public function top_students()
    {
        $students = Student::with('last_name')->orderBy('score', 'DESC')->take(3)->get(['id', 'first_name', 'image']);
        return response([
            $students
        ]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'score' => 'required|numeric|between:0,30',
            'class' => 'required|numeric|between:1,12'
        ]);

        $fields['father_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $fields['image'] = $request->file('image')->store('profiles', 'public');
        } else {
            $fields['image'] = 'storage/app/public/profiles/default.jpg';
        }

        Student::create($fields);

        return response([
            'message' => 'Student created successfully',
        ]);
    }

    public function update(Request $request, $student_id)
    {
        $fields = $request->validate([
            'first_name' => 'string',
            'score' => 'numeric|between:0,30',
            'class' => 'numeric|between:1,12'
        ]);

        if ($request->hasFile('image')) {
            $fields['image'] = $request->file('image')->store('profiles', 'public');
        }

        $student = auth()->user()->father->students()->find($student_id);
        if (!$student) {
            return response([
                'message' => 'Student Not Found',
            ], 422);
        }

        $student->update($fields);

        return response([
            'message' => 'Student updated successfully',
        ]);
    }

    public function destroy(Request $request, $student_id)
    {
        $password = $request->validate([
            'old_password' => 'required'
        ]);

        $student = auth()->user()->father->students()->find($student_id);
        if (!$student) {
            return response([
                'message' => 'Student Not Found',
            ], 422);
        }


        if (!Hash::check($password['old_password'], auth()->user()->password)) {
            return response([
                'message' => 'Wrong password',
            ], 422);
        }

        if (count(auth()->user()->father->students) == 1) {
            return response([
                'message' => 'You must have at least one student',
            ], 405);
        }

        $student->delete();

        return response([
            'message' => 'Deleted Successfully',
        ]);
    }

    public function accept_student(Request $request, $student_id)
    {
        $fields = $request->validate([
            'first_name' => 'string',
            'teacher_id' => 'required|integer|exists:teachers',
            'score' => 'numeric|between:0,30',
            'class' => 'numeric|between:1,12'
        ]);

        $student = Student::find($student_id);
        if (!$student) {
            return response([
                'message' => 'Student not found'
            ]);
        }

        if ($student->is_approved == 1) {
            return response([
                'message' => 'Student is already authorized'
            ]);
        }

        if ($request->hasFile('image')) {
            $fields['image'] = $request->file('image')->store('profiles', 'public');
        }

        $fields['is_approved'] = '1';

        $student->update($fields);

        return response([
            'message' => 'Student accepted successfully'
        ]);
    }

    public function delete_student($student_id)
    {
        $student = Student::find($student_id);

        if (!$student) {
            return response([
                'message' => 'Student not found',
            ], 404);
        }

        $student->delete();

        return response([
            'message' => 'Deleted Successfully',
        ]);
    }
}
