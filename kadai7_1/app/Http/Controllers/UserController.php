<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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

        $request_data = $request->all();
        return $this->userService->insertUser($request_data);
    }
}
