<?php

use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopAssignment;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('non authenticated user cannot access the assignments create page', function () {
    get(route('assignments.create'))
        ->assertRedirect(route('login'));
});

it('non admin user cannot access the assignments create page', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('assignments.create'))
        ->assertForbidden();
});

it('admin can access the assignments create page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)->get(route('assignments.create'))
        ->assertOk()
        ->assertComponent('Assignments/Create');
});

it('admin can create an assignment', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $workshop = Workshop::factory()->create();

    actingAs($admin)
        ->post(route('assignments.store'), [
            'user_id' => $user->id,
            'workshop_id' => $workshop->id,
            'role' => 'TIME_KEEPER',
        ])
        ->assertRedirect(route('workshops.show', $workshop->id));
});

it('non admin user cannot delete an assignment', function () {
    $user = User::factory()->create();
    $workshop = Workshop::factory()->create();
    $assignment = WorkshopAssignment::create([
        'user_id' => $user->id,
        'workshop_id' => $workshop->id,
        'role' => 'TIME_KEEPER',
    ]);

    actingAs($user)
        ->delete(route('assignments.destroy', $assignment))
        ->assertForbidden();
});

it('admin can delete an assignment', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $workshop = Workshop::factory()->create();
    $assignment = WorkshopAssignment::create([
        'user_id' => $user->id,
        'workshop_id' => $workshop->id,
        'role' => 'TIME_KEEPER',
    ]);

    actingAs($admin)
        ->delete(route('assignments.destroy', $assignment))
        ->assertRedirect(route('workshops.show', $workshop->id));

    $this->assertDatabaseMissing('workshop_assignments', [
        'id' => $assignment->id,
    ]);
});
