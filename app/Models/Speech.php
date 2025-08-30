<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speech extends Model
{
    /** @use HasFactory<\Database\Factories\SpeechFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    // speaker
    public function speaker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // workshop
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    // evaluator
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
