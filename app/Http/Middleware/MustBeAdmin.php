<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustBeAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $role = $user->role->where('role_id', 1)->first();
        if(!($role))
        {
            return response([
                'message' => 'You are not an admin'
            ], 422);
        }
        return $next($request);
    }
}
