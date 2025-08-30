<?php

namespace Database\Factories;

use App\Enums\PathWay;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

// Assuming PathWay is an enum defined in your application
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Speech>
 */
class SpeechFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => str(fake()->sentence)->beforeLast('.')->value(),
            'length' => fake()->numberBetween(5, 20),
            'pathway' => fake()->randomElement(PathWay::cases())->value, // Assuming PathWay is an enum
            'objectives' => fake()->paragraph(),
            'evaluator_notes' => fake()->paragraph(),
            'level' => fake()->numberBetween(1, 7),
            'project' => fake()->numberBetween(1, 4),

        ];
    }
}
