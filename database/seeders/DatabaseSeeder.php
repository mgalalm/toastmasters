<?php

namespace Database\Seeders;

use App\Enums\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Speech;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopAssignment;
use DateTime;
use Illuminate\Database\Seeder;

// Assuming peech is a model similar to Speech

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user_names = [
            'Anuj Kale',
            'Eileen Sheehan',
            'Mohamed Awad',
            'Fayola Peters',
            'Fergus O\'Neill',
            'Finn Hourigan',
            'James Mcnamara',
            'John Ryan',
            'Joseph Coleman',
            'Josephine O\'Brien',
            'Liam Quinn',
            'Marius D. van Niekerk',
            'Mark Quinn',
            'Martina Finnerty',
            'Mia Williams',
            'Noreen Mortell',
            'Stephanie Sandoval',
            'Tom P. Melly',
            'Una Ryan Kearns',
        ];

        foreach ($user_names as $name) {
            User::factory()->create(['name' => $name]);
        }

        // each workshop has 3 speeches
        $admin = User::factory()

            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin'), // Use bcrypt for password hashing
                'role' => 'admin', // Assuming role is a field in the User model
            ]);

        $president = User::factory()
            ->create([
                'name' => 'John Ryan',
                'email' => 'president@example.com',
                'password' => bcrypt('president'),
                'role' => 'admin',
            ]);

        // Helper to calculate workshop dates
        function getWorkshopDates($index)
        {
            $start = new DateTime('2025-09-11 20:00:00'); // First workshop
            $end = (clone $start)->modify('+2 hours');

            if ($index === 0) {
                return [
                    'starts_at' => $start->format('Y-m-d H:i:s'),
                    'ends_at' => $end->format('Y-m-d H:i:s'),
                ];
            }

            $current = clone $start;
            $count = 0;

            while ($count < $index) {
                // Go to next Thursday
                $current->modify('next Thursday');

                // Determine its position in the month
                $monthStart = new DateTime($current->format('Y-m-01'));
                $thursdayCount = 0;
                while ($monthStart <= $current) {
                    if ($monthStart->format('N') == 4) { // Thursday
                        $thursdayCount++;
                    }
                    $monthStart->modify('+1 day');
                }

                // Accept only 2nd or 4th Thursdays
                if (in_array($thursdayCount, [2, 4])) {
                    $count++;
                }
            }

            $start = (clone $current)->setTime(20, 0, 0);
            $end = (clone $start)->modify('+2 hours');

            return [
                'starts_at' => $start->format('Y-m-d H:i:s'),
                'ends_at' => $end->format('Y-m-d H:i:s'),
            ];
        }

        Workshop::factory(20)
            ->sequence(fn ($sequence) => array_merge(
                [
                    'title' => 'Workshop ' . ($sequence->index + 1),
                    'location' => 'Castletroy Park Hotel',
                ],
                getWorkshopDates($sequence->index)
            ))
            ->afterCreating(function ($workshop) use ($admin) {
                // Random 0–3 speeches for this workshop
                Speech::factory(rand(0, 3))
                    ->for($admin, 'speaker')
                    ->create(['workshop_id' => $workshop->id]);
            })
            ->has(
                WorkshopAssignment::factory()
                    ->state([
                        'user_id' => $president->id,
                        'role' => Role::PRESIDENT,
                    ]),
                'assignments'
            )
            ->create();

    }
}
