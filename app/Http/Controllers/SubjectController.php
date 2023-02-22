<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response($subjects);
    }

    public function show($id)
    {
        $subject = Subject::find($id);

        if($subject == null)
        return response(['message' => 'Subject not found'], 404);

        return response($subject,200);
    }

    public function store(Request $request)
    {
        $subject = request()->validate([
            'name' => 'required|min:3|max:45',
            'description' => 'max:255',
        ]);

        $subject = Subject::create($subject);

        return response($subject,200);
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);

        if($subject == null)
            return response(['message' => 'Subject not found'], 404);

            $credentials = $request->validate([
                'name' => 'string|max:45',
                'description' => 'string|max:255'
            ]);

            $subject->update($credentials);

        return response($subject,200);
    }

    public function delete($id)
    {
        $subject = Subject::find($id);
        
        if($subject == null)
          return response(['message' => 'Subject not found'], 404);

        $subject->delete();

        return response(['message'=>'Subject was deleted'],200);
    }
}
