<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = now()->addMonths(6);
        $endsAt = $startsAt->clone()->addMinutes(120);

        return [
            'title' => str(fake()->sentence)->beforeLast('.')->title(),
            'location' => fake()->city() . ', ' . fake()->country(),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ];
    }
}
