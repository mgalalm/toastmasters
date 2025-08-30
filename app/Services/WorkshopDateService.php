<?php

namespace App\Services;

use App\Models\Workshop;
use Carbon\Carbon;

class WorkshopDateService
{
    /**
     * Get available workshop dates between start & end.
     */
    public function getAvailableDates(Carbon $startDate, Carbon $endDate, int $maxSpeeches = 2): array
    {
        $dates = [];

        $current = $startDate->copy()->startOfMonth();
        while ($current->lessThanOrEqualTo($endDate)) {
            // 2nd Thursday
            $secondThursday = $this->nthThursdayOfMonth($current, 2);
            $this->addIfAvailable($dates, $secondThursday, $startDate, $endDate, $maxSpeeches);

            // 4th Thursday
            $fourthThursday = $this->nthThursdayOfMonth($current, 4);
            $this->addIfAvailable($dates, $fourthThursday, $startDate, $endDate, $maxSpeeches);

            $current->addMonth();
        }

        return $dates;
    }

    public function getAvailableDatesFromConfig(int $maxSpeeches = 3): array
    {
        $start = Carbon::parse(config('workshops.start_date', '2025-01-01'));
        $end = Carbon::parse(config('workshops.end_date', '2025-12-31'));

        return $this->getAvailableDates($start, $end, $maxSpeeches);
    }

    private function addIfAvailable(array &$dates, Carbon $date, Carbon $start, Carbon $end, int $maxSpeeches)
    {
        if (! $date->between($start, $end)) {
            return;
        }

        $count = Workshop::whereDate('starts_at', $date)
            ->withCount('speeches')
            ->first()?->speeches_count ?? 0;

        if ($count < $maxSpeeches) {
            $dates[] = $date->toDateString();
        }
    }

    private function nthThursdayOfMonth(Carbon $date, int $nth): Carbon
    {
        // Start from the 1st of the month
        $day = $date->copy()->startOfMonth();

        // Move forward until we hit the first Thursday
        while ($day->dayOfWeek !== Carbon::THURSDAY) {
            $day->addDay();
        }

        // Add (n-1) weeks
        return $day->addWeeks($nth - 1);
    }
}
