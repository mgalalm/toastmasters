<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('non authenticated user cannot access the users create page', function () {
    get(route('users.create'))
        ->assertRedirect(route('login'));
});

it('non admin user cannot access the users create page', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('users.create'))
        ->assertForbidden();
});

it('admin can access the users create page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)->get(route('users.create'))
        ->assertOk()
        ->assertComponent('Users/Create');
});
