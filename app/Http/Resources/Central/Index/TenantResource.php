<?php

namespace App\Http\Resources\Central\Index;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = json_decode($this['data'], true);

        return [
            'id' => $this['id'],
            'name' => $data['name'],
            'domain' => $this->tenant->domain(),
        ];
    }
}
