<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;

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

    public function create(UserRequest $request)
    {
        $request->validated();
        return $this->userService->insertUser($request->only(['nickname']));
    }

    public function login(LoginRequest $request)
    {
        // validationされる
        $request->validated();

        // Create a token
        $token = random_bytes(8);
        $token = substr(bin2hex($token), 0, 8);
        $result = $this->userService->assignTokenToUser($request->id, $token);
        return $token;
    }
}
