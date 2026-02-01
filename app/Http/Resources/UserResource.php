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
        // dd($this->role);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo' => $this->profile_photo_url,
            'created_at' => $this->created_at,
            'active' => (bool) $this->active,
            'role' => $this->role,
            'assignments' => $this->whenLoaded('assignments'),
            'speeches' => $this->whenLoaded('speeches'),
            // 'assignments_count' => $this->assignments()->count(),
        ];
    }
}
