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
            'length' => $this->length,
            'pathway' => $this->pathway,
            'objectives' => $this->objectives,
            'evaluator_notes' => $this->evaluator_notes,

        ];
    }
}
