<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Traits\HasHttpResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Central\Auth\AuthResource;
use App\Http\Resources\Central\Auth\AuthenticatedSessionResource;

class AuthenticatedSessionController extends Controller
{
    use HasHttpResponse;

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();

        $expiration = $request->boolean('remember') ? null : now()->addDay(1);

        $user['token'] = $user->createToken('web-api-token', ['*'], $expiration);

        return $this->success(new AuthenticatedSessionResource($user), 200, 'logged in successfully');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 200, 'logged out successfully');
    }

    /**
     * Check if the user is authenticated.
     */
    public function authCheck()
    {
        return $this->success(new AuthResource(Auth::user()), 200);
    }
}
