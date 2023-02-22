<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Session;
use App\Models\Student;

class RatingController extends Controller
{
    public function store()
    {
        $rating = request()->validate([
            'session_id' => 'required|numeric',
            'student_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'rate' =>'required|integer|between:0,10'
        ]);

        $session = Session::find($rating['session_id']);
        if(!$session)
        return response(['message' => 'Session not found.'],404);

        $student = Student::find($rating['student_id']);
        if(!$student)
            return response(['message' => 'Student not found.'],404);

        $subject = Student::find($rating['subject_id']);
        if(!$subject)
            return response(['message' => 'Subject not found.'],404);

        if(auth()->user()->id != $session['teacher_id'])
            return response(['message' => 'you are not allowed to access this session.'],403);

        if(auth()->user()->id != $student['teacher_id'])
            return response(['message' => 'you are not allowed to access this student.'],403);

        $rating = Rating::create($rating);

        return response($rating,200);
    }

    public function delete($session_id)
    {
        $session = Session::find($session_id);
        
        if(!$session)
          return response(['message' => 'Rating not found'], 404);

        $session->delete();

        return response(['message'=>'Rating was deleted'],200);
    }
    
    public function update($id)
    {
        $rating = Rating::find($id);

        if(!$rating)
            return response(['message' => 'Rating not found'], 404);

            $credentials = request()->validate([
                'rate' => 'integer|between:0,10',
            ]);

            $rating->update($credentials);

        return response($rating,200);
    }

}
