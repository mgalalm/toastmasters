<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class WorkshopAssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'workshop_id' => $this->workshop_id,
            'workshop_title' => $this->whenLoaded('workshop')->title ?? null,
            'user_id' => $this->user_id,
            'name' => $this->whenLoaded('user')->name ?? null,
            'photo' => $this->whenLoaded('user')->profile_photo_url ?? null,
            'role' => Str::of($this->role)->replace('_', ' '),
        ];
    }
}
