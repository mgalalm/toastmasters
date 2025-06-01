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
        return $this->belongsTo(User::class);
    }
}
