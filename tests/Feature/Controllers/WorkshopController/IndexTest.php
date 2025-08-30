<?php

use App\Http\Resources\WorkshopResource;
use App\Models\User;
use App\Models\Workshop;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('non authenticated user can\'t access the workshops index', function () {
    get(route('workshops.index'))
        ->assertRedirect(route('login'));
});

it('can access the workshop index', function () {
    $user = User::factory()->create();
    actingAs($user)->get(route('workshops.index'))
        ->assertOk();
});

it('should return the correct component', function () {
    $user = User::factory()->create();
    actingAs($user)->get(route('workshops.index'))
        ->assertComponent('Workshops/Index');
});

// it('passes the workshops to the view', function () {
//     $user = User::factory()
//         ->has(
//             Workshop::factory()->count(5)
//         )->create();

//     $workshops = Workshop::all();
//     $workshops->load('facilitator');

//     actingAs($user)->get(route('workshops.index'))
//         ->assertHasPaginatedResource('workshops', WorkshopResource::collection($workshops->reverse()));
// });
