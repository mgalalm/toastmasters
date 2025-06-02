<?php

// require authentication
use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('requires authentication', function () {
    post(route('speeches.store'))
        ->assertRedirect(route('login'));
});

// can store a speech

it('can store a speech', function () {
    $user = User::factory()->create();
    $data = Speech::factory()->make()->toArray();
    // dd($data);

    actingAs($user)->post(route('speeches.store'), $data)
        ->assertRedirect(route('speeches.index'));

    $this->assertDatabaseHas('speeches', [
        'title' => $data['title'],
        'length' => $data['length'],
        'user_id' => $user->id,
    ]);
});
