<?php

namespace App\Policies;

use App\Models\Speech;
use App\Models\User;

class SpeechPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Speech $speech): bool
    {
        return $this->isOwner($user, $speech);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Speech $speech): bool
    {
        // dd($speech->user_id === $user->id);
        return $this->isOwner($user, $speech) or $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Speech $speech): bool
    {
        // Only allow deletion if the user is the owner of the speech
        return $this->isOwner($user, $speech) or $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Speech $speech): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Speech $speech): bool
    {
        return false;
    }

    private function isOwner(User $user, Speech $speech): bool
    {
        return $speech->user_id === $user->id;
    }
}
