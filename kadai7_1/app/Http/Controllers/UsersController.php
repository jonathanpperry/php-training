<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('users.index')->with('users', $users);
    }

    public function create(Request $request)
    {
        if (empty($request['nickname'])) {
            $error_msg = array("nickname_error" => "ユーザー名を入力してください");
            return response()->json($error_msg);
            exit;
        }

        User::create([
            'nickname' => $request['nickname'],
            'level' => $request['level'],
            'exp' => $request['exp'],
        ]);
        return new UserResource(User::orderBy('id', 'desc')->first());
    }
}
