<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::with('teacher')->get();
        return response($sessions);
    }

    public function show($id)
    {
        $session = Session::where('id', $id)->with('teacher')->first();
        if(!$session)
            return response(['message' => 'session not found'],404);

        return response($session,200);
    }

    public function store()
    {
        $session = [
            'teacher_id' => auth()->user()->id,
            'date' => date('y-m-d',time())
        ];

        $session = Session::create($session);

        return response($session,200);
    }

    public function delete($id)
    {
        $session = Session::find($id);
        
        if($session == null)
          return response(['message' => 'session not found'], 404);

        if($session['teacher_id'] != auth()->user()->id)
          return response(['message' => 'you are not the owner of this session'], 403);

        $session->delete();

        return response(['message'=>'session was deleted'],200);
    }
}
