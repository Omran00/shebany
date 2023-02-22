<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustBeFather
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $role = $user->role->where('role_id', 2)->first();
        if(!($role))
        {
            return response([
                'message' => 'You are not a father'
            ], 422);
        }
        return $next($request);
    }
}
