
<?php

use App\Models\Speech;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

it('requires authentication', function () {
    $speech = Speech::factory()->create();
    delete(route('speeches.destroy', $speech))->assertRedirect(route('login'));
});

it('can delete a speech', function () {
    $user = User::factory()->has(
        Speech::factory()->count(1)
    )->create();

    $speech = $user->speeches->first();
    actingAs($user)->delete(route('speeches.destroy', $speech))
        ->assertRedirect(route('speeches.index'));
});

it('can\'t delete a speech with a different user', function () {
    $user = User::factory()->has(
        Speech::factory()->count(1)
    )->create();

    $otherUser = User::factory()->create();
    $speech = $user->speeches->first();
    actingAs($otherUser)->delete(route('speeches.destroy', $speech))
        ->assertForbidden();
});
