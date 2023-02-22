<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DataMustBeCompleted
{    
    
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $role = $user->role->where('role_id', 2)->first();
        $students = $user->father->students->first();
        if(!(isset($role) && isset($students)))
        
        {
            return response([
                'message' => 'You must have at least one student',
            ], 405);
        }
        return $next($request);
    }
}
