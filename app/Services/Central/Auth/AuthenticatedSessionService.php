<?php

namespace App\Services\Central\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Traits\HasHttpResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class AuthenticatedSessionService.
 */
class AuthenticatedSessionService
{
    use HasHttpResponse;

    public function store($data)
    {
        try {
            $data->authenticate();

            $user = $data->user();

            $user->tokens()->where('name', 'web-api-token')->delete();

            $expiresToken = $data->boolean('remember') ? now()->addDays(7) : now()->addMinutes(60);
            $expiresRefreshToken = $data->boolean('remember') ? now()->addDays(14) : now()->addMinutes(120);

            $user['token'] = $user->createToken('web-api-token', ['*'], $expiresToken);

            $user['refreshToken'] = Str::random(64);

            DB::table('personal_refresh_tokens')->insert([
                'user_id'    => $user->id,
                'personal_access_token_id' => $user['token']->accessToken->id,
                'token'      => hash('sha256', $user['refreshToken']),
                'expires_at' => $expiresRefreshToken,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $user;
        } catch (\Throwable $e) {
            $this->handleErrorCondition(true, 'Login failed. Please try again. Error: ' . $e->getMessage(), 500);
        }
    }

    public function refresh(array $data)
    {
        $hashed = hash('sha256', $data['refresh-token']);

        $stored = DB::table('personal_refresh_tokens')
            ->join('users', 'personal_refresh_tokens.user_id', '=', 'users.id')
            ->where('personal_refresh_tokens.token', $hashed)
            ->whereNull('personal_refresh_tokens.revoked_at')
            ->select('personal_refresh_tokens.*', 'users.*', 'personal_refresh_tokens.id as refresh_token_id', 'users.id as user_id')
            ->first();

        $this->handleErrorCondition(
            !$stored || strtotime($stored->expires_at) < time(),
            'Invalid refresh token',
            401
        );

        DB::table('personal_refresh_tokens')
            ->where('id', $stored->refresh_token_id)
            ->update(['revoked_at' => now()]);

        $expiresToken = $stored->remember_token !== null ? now()->addDays(7) : now()->addMinutes(60);
        $expiresRefreshToken = $stored->remember_token !== null ? now()->addDays(14) : now()->addMinutes(120);

        $userModel = User::find($stored->user_id);

        $userModel['token'] = $userModel->createToken('web-api-token', ['*'], $expiresToken);
        $userModel['refreshToken'] = Str::random(64);

        DB::table('personal_refresh_tokens')->insert([
            'user_id'    => $stored->user_id,
            'personal_access_token_id' => $userModel['token']->accessToken->id,
            'token'      => hash('sha256', $userModel['refreshToken']),
            'expires_at' => $expiresRefreshToken,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $userModel;
    }
}
