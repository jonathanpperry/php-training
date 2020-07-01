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
        $returnObject = $this->userService->isInMaintenanceWindow();
        if ($returnObject) {
            return response()->json(['data' => ["メンテナンス中です。{$returnObject[0]}～{$returnObject[1]}"]], 200);
        }
        return $next($request);
    }
}
