
<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

// doesn't show create product form for guest
it('doesn\'t show create product form for guest', function () {
    $this->get(route('speeches.create'))
        ->assertRedirect(route('login'));
});

// shows create product form for authenticated user
it('shows create product form for authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get(route('speeches.create'))
        ->assertOk();
});

it('returns the correct component', function () {
    $user = User::factory()->create();
    actingAs($user)->get(route('speeches.create'))
        ->assertComponent('Speeches/Create');
});
