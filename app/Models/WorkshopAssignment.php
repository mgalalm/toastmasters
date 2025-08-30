<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopAssignment extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopAssignmentFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    // user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // workshop
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }
}
