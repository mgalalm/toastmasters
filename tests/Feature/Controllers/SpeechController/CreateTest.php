
<?php

use App\Enums\PathWay;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Ensure the database is clean before each test
    $this->user = User::factory()->create();
});

// doesn't show create product form for guest
it('doesn\'t show create product form for guest', function () {
    $this->get(route('speeches.create'))
        ->assertRedirect(route('login'));
});

// shows create product form for authenticated user
it('shows create product form for authenticated user', function () {
    $this->actingAs($this->user)
        ->get(route('speeches.create'))
        ->assertOk();
});

it('returns the correct component', function () {
    $user = User::factory()->create();
    actingAs($this->user)->get(route('speeches.create'))
        ->assertComponent('Speeches/Create');
});

it('has pathways in the view', function () {
    actingAs($this->user)->get(route('speeches.create'))
        ->assertInertia(fn ($inertia) => $inertia->has('pathways')
            ->where('pathways', PathWay::allPathways()));
});
