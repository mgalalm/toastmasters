<?php

use App\Models\Speech;
use App\Models\Workshop;
use App\Services\WorkshopDateService;
use Carbon\Carbon;

beforeEach(function () {
    $this->service = new WorkshopDateService;
});

/**
 * Helper to freeze "now" for Carbon
 */
function freeze(string $date): void
{
    Carbon::setTestNow(Carbon::parse($date));
}

it('returns 2nd and last Thursdays within range', function () {
    freeze('2025-09-11'); // Freeze time to September 11, 2025 to test date calculations

    $start = Carbon::parse('2025-09-01');
    $end = Carbon::parse('2025-09-30');

    $dates = $this->service->getAvailableDates($start, $end);

    // For March 2025:
    // 2nd Thursday = 13th, last Thursday = 27th
    expect($dates)->toBe([
        '2025-09-11',
        '2025-09-25',
    ]);

});

it('excludes dates with too many speeches', function () {
    freeze('2025-09-11');

    $start = Carbon::parse('2025-09-01');
    $end = Carbon::parse('2025-09-30');

    // Create a workshop on September 11 (2nd Thursday)
    $workshop = Workshop::factory()->create([
        'starts_at' => '2025-09-11',
    ]);

    // Attach 3 speeches (reaches the max)
    Speech::factory()->count(3)->create([
        'workshop_id' => $workshop->id,
    ]);

    $dates = $this->service->getAvailableDates($start, $end);

    // Only last Thursday should remain
    expect($dates)->toBe([
        '2025-09-25',
    ]);
});
