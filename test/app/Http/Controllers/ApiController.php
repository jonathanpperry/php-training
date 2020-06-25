<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ApiController extends Controller
{
    public function create(Request $request)
    {
        $users = new User();

        $users->nickname = $request->input('nickname');
        $users->nickname = $request->input('level');
        $users->nickname = $request->input('exp');

        $users->save();
        return response()->json();
    }
}
