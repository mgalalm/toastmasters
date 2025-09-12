<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeechResource extends JsonResource
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
            'title' => $this->title,
            'created_at' => $this->created_at,
            'length' => (int) $this->length,
            'pathway' => $this->pathway,
            'level' => $this->level,
            'project' => $this->project,
            'objectives' => $this->objectives,
            'evaluator_notes' => $this->evaluator_notes,
            'speaker' => $this->whenLoaded('speaker', fn () => $this->speaker->name, 'Unassigned'),
            'speaker_id' => $this->user_id,
            'evaluator_id' => $this->evaluator_id,
            'evaluator' => $this->whenLoaded('evaluator', fn () => $this->evaluator->name, 'Unassigned'),
            'profile_photo' => $this->whenLoaded('speaker', fn () => $this->speaker?->profile_photo_url ?? ''),
        ];
    }
}
