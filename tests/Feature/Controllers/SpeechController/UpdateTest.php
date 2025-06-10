<?php

use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->speech = Speech::factory()->create([
        'user_id' => $this->user->id,
    ]);
    $this->data = $this->speech->toArray();
    $this->route = route('speeches.update', $this->speech);

});

it('requires authentication', function () {
    put($this->route)
        ->assertRedirect(route('login'));
});

it('does not update speech for other users', function () {

    $otherUser = User::factory()->create();
    actingAs($otherUser)
        ->put(route('speeches.update', $this->speech),
            $this->data
        )
        ->assertForbidden();
});

it('can update the speech for the owner', function () {

    $this->data['title'] = $new_title = 'Updated Title';
    $this->data['length'] = $new_length = $this->data['length'] + 1;

    actingAs($this->user)->put($this->route, $this->data)
        ->assertRedirect(route('speeches.index'));

    $this->assertDatabaseHas('speeches', [
        'id' => $this->speech->id,
        'title' => $new_title,
        'length' => $new_length,
        'user_id' => $this->user->id,
    ]);
});

it('requires a valid title', function ($value) {
    $this->data['title'] = $value;
    actingAs($this->user)->put($this->route, $this->data)
        ->assertInvalid('title');
})->with([
    'empty title' => '',
    'title too long' => str_repeat('a', 256),
]);

it('requires a valid length', function ($value) {
    $this->data['length'] = $value;
    actingAs($this->user)->put($this->route, $this->data)
        ->assertInvalid('length');
})->with([
    'negative length' => -1,
    'zero length' => 0,
    'non-integer length' => 'not a number',
    'length too long' => 31, // Assuming the max length is 99999
]);

it('requires a valid pathway', function ($value) {
    $this->data['pathway'] = $value;

    actingAs($this->user)->put($this->route, $this->data)
        ->assertInvalid('pathway');
})->with([
    'empty pathway' => '',
    'invalid pathway' => 'Invalid Pathway',
]);
