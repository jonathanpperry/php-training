<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('users.index')->with('users', $users);
    }

    /**
     * Create a user
     *
     * @param UserCreateRequest $request
     * @return JsonResponse
     */

    public function create(Request $request)
    {
        if (empty($request['nickname'])) {
            $error_msg = array("nickname_error" => "ユーザー名を入力してください");
            return response()->json($error_msg);
            exit;
        }

        $user = new User;

        $user->nickname = $request->nickname;
        $user->level = $request->level;
        $user->exp = $request->exp;

        $user->save();
    }
}
