<?php

use App\Enums\PathWay;
use App\Http\Resources\SpeechResource;
use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->speech = $this->user->speeches()->save(Speech::factory()->make());
});

it('does not show edit speech form for guest', function () {
    $this->get(route('speeches.edit', $this->speech))
        ->assertRedirect(route('login'));
});

it('show edit speech for the owner', function () {

    $this->actingAs($this->user)
        ->get(route('speeches.edit', $this->speech))
        ->assertOk();
});

it('does not show edit speech for other users', function () {

    $otherUser = User::factory()->create();

    $this->actingAs($otherUser)
        ->get(route('speeches.edit', $this->speech))
        ->assertForbidden();
});

it('returns the correct component', function () {

    actingAs($this->user)->get(route('speeches.edit', $this->speech))
        ->assertComponent('Speeches/Create');
});

it('passes the speech to the view', function () {
    actingAs($this->user)->get(route('speeches.edit', $this->speech))
        ->assertHasResource('speech', SpeechResource::make($this->speech));
});

it('has pathways in the view', function () {
    actingAs($this->user)->get(route('speeches.edit', $this->speech))
        ->assertInertia(fn ($inertia) => $inertia->has('pathways')
            ->where('pathways', PathWay::allPathways()));
});
