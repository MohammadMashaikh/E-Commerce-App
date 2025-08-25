<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = $this->getFirstMedia('admin-user-image');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'role_id' => $this->role_id,
            'role_name' => $this->role->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $image ? [
                'id' => $image->id,
                'url' => $image->getUrl()
            ] : null,
        ];
    }
}
