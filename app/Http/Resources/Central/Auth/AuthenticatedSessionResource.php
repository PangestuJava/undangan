<?php

namespace App\Http\Resources\Central\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->token->plainTextToken,
            'refresh-token' => $this->refreshToken,
            'expires_at' => $this->token->accessToken->expires_at
        ];
    }
}
