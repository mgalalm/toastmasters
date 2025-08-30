<?php

use App\Http\Resources\SpeechResource;
use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// anonymous function to test the index method of SpeechController

it('non authenticated user can\'t access the speeches index', function () {
    get(route('speeches.index'))
        ->assertRedirect(route('login'));
});

it('can access the index page', function () {
    $user = User::factory()->create();
    actingAs($user)->get(route('speeches.index'))
        ->assertOk();
});

it('Users can\'t see the other users\'speeches', function () {
    $user = User::factory()->has(
        Speech::factory()->count(5)
    )->create();

    $otherUser = User::factory()->create();
    actingAs($otherUser)->get(route('speeches.index'))
        ->assertHasPaginatedResource('speeches', SpeechResource::collection([]));

});

it('should return the correct component', function () {
    $user = User::factory()->create();
    actingAs($user)->get(route('speeches.index'))
        ->assertComponent('Speeches/Index');
});

it('passes the speeches to the view', function () {
    // create speeches
    $user = User::factory()
        ->has(
            Speech::factory()->count(5)
        )->create();

    $speeches = Speech::all();
    $speeches->load(['speaker', 'evaluator']);

    actingAs($user)->get(route('speeches.index'))
        ->assertHasPaginatedResource('speeches', SpeechResource::collection($speeches->reverse()));
});
