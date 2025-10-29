<?php

use App\Http\Resources\SpeechResource;
use App\Http\Resources\UserResource;
use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('can show user', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('users.show', $user))
        ->assertOk()
        ->assertComponent('Users/Show');
});

it('passes user to the view', function () {
    $user = User::factory()->create();

    // load the user from the database

    // dd($user->toArray());
    actingAs($user)
        ->get(route('users.show', $user))
        ->assertHasResource('user', UserResource::make($user));
});

// passes speeches to the view
it('passes speeches to the view', function () {
    $user = User::factory()->create();
    $speeches = Speech::factory()->count(2)->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('users.show', $user))
        ->assertHasResource('speeches', SpeechResource::collection($speeches));
});

it('doesn\'t show speech for other users', function () {
    $user = User::factory()->create();
    $anotherUser = User::factory()->create();
    actingAs($anotherUser)
        ->get(route('users.show', $user))
        ->assertForbidden();
});

// it doesn't show speech for anonymous users
it('doesn\'t show speech for anonymous users', function () {
    $user = User::factory()->create();
    $this->get(route('users.show', $user))
        ->assertRedirect(route('login'));
});

it('admin can view any user', function () {
    $admin = User::factory(
        ['role' => User::ROLE_ADMIN]
    )->create();
    $user = User::factory()->create();

    actingAs($admin)
        ->get(route('users.show', $user))
        ->assertOk()
        ->assertComponent('Users/Show');
});
