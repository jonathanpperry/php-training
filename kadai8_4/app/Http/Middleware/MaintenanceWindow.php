<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;

class MaintenanceWindow
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isInMaintenanceWindow = $this->userService->isInMaintenanceWindow();
        if ($isInMaintenanceWindow) {
            return response()->json(['data' => ['メンテナンス中です。(開始時間)～(終了時間)']], 200);
        }
        return $next($request);
    }
}
