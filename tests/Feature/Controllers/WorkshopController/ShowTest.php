

<?php
use App\Http\Resources\WorkshopResource;
use App\Models\User;
use App\Models\Workshop;

use function Pest\Laravel\actingAs;

it('members can show workshop', function () {
    $workshop = Workshop::factory()->create();
    $user = User::factory()->create();
    actingAs($user)
        ->get(route('workshops.show', $workshop))
        ->assertOk()
        ->assertComponent('Workshops/Show');
});

it('passes workshop to the view', function () {
    $workshop = Workshop::factory()->create();
    $user = User::factory()->create();
    actingAs($user)
        ->get(route('workshops.show', $workshop))
        ->assertHasResource('workshop', WorkshopResource::make($workshop));
});

it('doesn\'t show workshop for anonymous users', function () {
    $workshop = Workshop::factory()->create();
    $this->get(route('workshops.show', $workshop))
        ->assertRedirect(route('login'));
});
