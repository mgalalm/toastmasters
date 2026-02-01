<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('non authenticated user cannot access the users edit page', function () {
    $user = User::factory()->create();

    get(route('users.edit', $user))
        ->assertRedirect(route('login'));
});

it('non admin user cannot access the users edit page', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    actingAs($user)->get(route('users.edit', $otherUser))
        ->assertForbidden();
});

it('admin can access the users edit page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    actingAs($admin)->get(route('users.edit', $user))
        ->assertOk()
        ->assertComponent('Users/Create');
});

it('admin can update a user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    actingAs($admin)
        ->put(route('users.update', $user), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'member',
            'password' => '',
            'profile_photo_path' => '',
            'active' => true,
        ])
        ->assertRedirect(route('users.show', $user));
});
