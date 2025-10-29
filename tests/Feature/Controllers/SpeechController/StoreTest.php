<?php

// require authentication
use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->data = Speech::factory()->make()->toArray();
});

it('requires authentication', function () {
    post(route('speeches.store'))
        ->assertRedirect(route('login'));
});

it('can store a speech', function () {
    // dd($this->data);
    actingAs($this->user)->post(route('speeches.store'), $this->data)
        ->assertRedirect(route('speeches.index'));
    // dd( $this->user->get());
    $this->assertDatabaseHas('speeches', [
        'title' => $this->data['title'],
        'length' => $this->data['length'],
        'user_id' => $this->user->id,
    ]);
});

it('requires a valid title', function ($value) {
    $this->data['title'] = $value;
    actingAs($this->user)->post(route('speeches.store'), $this->data)
        ->assertInvalid('title');
})->with([
    'empty title' => '',
    'title too long' => str_repeat('a', 256),
]);

it('requires a valid length', function ($value) {
    $this->data['length'] = $value;
    actingAs($this->user)->post(route('speeches.store'), $this->data)
        ->assertInvalid('length');
})->with([
    'negative length' => -1,
    'zero length' => 0,
    'non-integer length' => 'not a number',
    'length too long' => 31, // Assuming the max length is 99999
]);

it('requires a valid pathway', function ($value) {
    $this->data['pathway'] = $value;

    actingAs($this->user)->post(route('speeches.store'), $this->data)
        ->assertInvalid('pathway');
})->with([
    'empty pathway' => '',
    'invalid pathway' => 'Invalid Pathway',
]);

it('requires a valid workshop id if provided', function ($value) {
    $this->data['workshop_id'] = $value;

    actingAs($this->user)->post(route('speeches.store'), $this->data)
        ->assertInvalid('workshop_id');
})->with([
    'invalid workshop id' => 999,
]);

it('admin can store speech for another user', function () {
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
    $otherUser = User::factory()->create();
    $this->data['speaker'] = $otherUser->id;

    actingAs($admin)->post(route('speeches.store'), $this->data)
        ->assertRedirect(route('speeches.index'));

    $this->assertDatabaseHas('speeches', [
        'title' => $this->data['title'],
        'length' => $this->data['length'],
        'user_id' => $otherUser->id,
    ]);
});
