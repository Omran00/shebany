<?php

namespace App\Http\Controllers;

use App\Models\Father;
use Illuminate\Http\Request;

class FatherController extends Controller
{
    public function all_accepted_fathers()
    {
        $fathers = Father::with('user')->whereRelation('user', 'is_approved', 1)->get();
        return response([
            $fathers
        ]);
    }

    public function all_pending_fathers()
    {
        $fathers = Father::with('user')->whereRelation('user', 'is_approved', 0)->get();

        return response([
            $fathers
        ]);
    }
}
