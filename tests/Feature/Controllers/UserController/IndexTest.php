<?php

use App\Http\Resources\UserResource;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// anonymous function to test the index method of SpeechController

it('non authenticated user can\'t access the users index', function () {
    get(route('users.index'))
        ->assertRedirect(route('login'));
});

// non admin user can't access the users index
it('non admin user can\'t access the users index', function () {
    $user = User::factory()->create();
    actingAs($user)->get(route('users.index'))
        ->assertForbidden();
});

it('can access the index page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    actingAs($admin)->get(route('users.index'))
        ->assertOk();
});

it('should return the correct component', function () {
    $admin = User::factory()->create(
        ['role' => 'admin']
    );

    actingAs($admin)->get(route('users.index'))
        ->assertComponent('Users/Index');
});

// it('passes the users to the view', function () {
//     // create speeches
//     $admin = User::factory()->create(
//         ['role' => 'admin']
//     );

//     $users = User::factory()->count(2)->create();
//     $users->push($admin);
//     $users = $users->sortBy('name');

//     actingAs($admin)->get(route('users.index'))
//         ->assertHasPaginatedResource('users', UserResource::collection($users));
// });
