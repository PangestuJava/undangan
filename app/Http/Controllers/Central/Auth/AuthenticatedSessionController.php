<?php

namespace App\Http\Controllers\Central\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Central\Auth\LoginRequest;
use App\Http\Resources\Central\Auth\AuthResource;
use App\Http\Requests\Central\Auth\RefreshTokenRequest;
use App\Services\Central\Auth\AuthenticatedSessionService;
use App\Http\Resources\Central\Auth\AuthenticatedSessionResource;

class AuthenticatedSessionController extends Controller
{
    protected $authenticatedSessionService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\Central\AuthenticatedSessionService $authenticatedSessionService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = $this->authenticatedSessionService->store($request);

        return $this->authenticatedSessionService->success(new AuthenticatedSessionResource($user), 200, 'logged in successfully');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->authenticatedSessionService->success(null, 200, 'logged out successfully');
    }

    /**
     * Check if the user is authenticated.
     */
    public function authCheck()
    {
        return $this->authenticatedSessionService->success(new AuthResource(Auth::user()), 200);
    }

    /**
     * Refresh the access token using the refresh token.
     */
    public function refreshToken(RefreshTokenRequest $request)
    {
        $data = $request->validated();

        $user = $this->authenticatedSessionService->refresh($data);

        return $this->authenticatedSessionService->success(new AuthenticatedSessionResource($user), 200, 'refresh token successfully');
    }
}
