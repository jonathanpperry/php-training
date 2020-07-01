<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ErrorController;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\GameOverRequest;

class UserController extends Controller
{
    private $userService;
    private $errorController;

    public function __construct(
        UserService $userService,
        ErrorController $errorController
    ) {
        $this->userService = $userService;
        $this->errorController = $errorController;
    }

    /**
     * Create a user
     *
     * @param UserCreateRequest $request
     * @return JsonResponse
     */

    public function create(UserRequest $request)
    {
        return $this->userService->insertUser($request->only(['nickname']));
    }

    public function login(LoginRequest $request)
    {
        $loginResponse = $this->userService->assignTokenToUser($request->id);
        // Login error is handled in service, so return response if returned
        return $loginResponse;
    }

    public function confirm(ConfirmRequest $request)
    {
        $confirmResponse = $this->userService->confirmUserToken($request->id, $request->token);
        // Errors are now handled in the user service via the error controller
        return $confirmResponse;
    }

    public function gameover(GameOverRequest $request)
    {
        // Check if the request is for a non-existent user
        if ($this->userService->getUserByUserID($request->id) === null) {
            $this->errorController->handleError("100011");
        }
        // Update the level if needed
        $gameoverResponse = $this->userService->incrementExperienceAndUpdateLevel($request->id, $request->exp);
        return response()->json(['data' => $gameoverResponse], 200);
    }
}
