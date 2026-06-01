<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enum\User\UserRoleEnum;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, array ...$roles): Response
    {
        $user = $request->user();
        $allowed = array_map(fn($r) => UserRoleEnum::from($r), $roles);

        dd($allowed);

        if (!$request->user() || !in_array($request->user()->role->value, $roles))
            return response()->json(['message' => 'You are not authorize to access this'], 403);

        return $next($request);
    }
}
