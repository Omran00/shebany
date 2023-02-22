<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function all_accepted_teachers()
    {
        $teachers = Teacher::with('user')->whereRelation('user', 'is_approved', 1)->get();
        return response([
            $teachers
        ]);
    }

    public function all_pending_teachers()
    {
        $teachers = Teacher::with('user')->whereRelation('user', 'is_approved', 0)->get();
        return response([
            $teachers
        ]);
    }

    public function show($teacher_id)
    {
        $teacher = Teacher::with('user')->find($teacher_id);
        if ($teacher?->user->is_approved == 0) {
            return response([
                'message' => 'Teacher not found'
            ]);
        }
        return response([
            $teacher
        ]);
    }
}
