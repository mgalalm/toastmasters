<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    // speeches
    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

    public function assignments()
    {
        return $this->hasMany(WorkshopAssignment::class);
    }

    // compute attribute called date which ext the date from starts_at

    public function getDateAttribute()
    {
        return Carbon::parse($this->starts_at)?->toDateString();
    }

    public function scopeAvailable($query)
    {
        return $query->withCount('speeches')
            ->having('speeches_count', '<', 3)
            ->orderBy('starts_at');
    }
}
