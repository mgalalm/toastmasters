<?php

use App\Http\Resources\SpeechResource;
use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('can show speech', function () {
    $speech = Speech::factory()->create();

    actingAs($speech->speaker)
        ->get(route('speeches.show', $speech))
        ->assertOk()
        ->assertComponent('Speeches/Show');
});

it('passes speech to the view', function () {
    $speech = Speech::factory()->create();
    $speech->load(['speaker', 'evaluator']);
    actingAs($speech->speaker)
        ->get(route('speeches.show', $speech))
        ->assertHasResource('speech', SpeechResource::make($speech));
});

it('doesn\'t show speech for other users', function () {
    $speech = Speech::factory()->create();
    actingAs(User::factory()->create())
        ->get(route('speeches.show', $speech))
        ->assertForbidden();
});

// it doesn't show speech for anonymous users
it('doesn\'t show speech for anonymous users', function () {
    $speech = Speech::factory()->create();
    $this->get(route('speeches.show', $speech))
        ->assertRedirect(route('login'));
});
