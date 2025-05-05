<?php

namespace App\Http\Resources\Central\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'  => $this->uuid,
            'email' => $this->email,
            'username' => $this->username,
            // 'detail' => $this->userDetail,
            // 'role' => $this->getRoleNames(),
        ];
    }
}
