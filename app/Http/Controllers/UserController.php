<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeechResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkshopAssignmentResource;
use App\Models\User;

class UserController extends Controller
{
    // index method to list all users
    public function index()
    {
        $users = User::orderBy('active', 'desc')->orderBy('name', 'asc')->with(['assignments', 'speeches'])->paginate(16);

        return inertia('Users/Index', [
            'users' => UserResource::collection($users),
        ]);
    }

    public function show(User $user)
    {
        $speeches = $user->speeches()->get();

        return inertia('Users/Show', [
            'user' => UserResource::make($user),
            'speeches' => SpeechResource::collection($speeches),
            'evaluations' => SpeechResource::collection($user->evaluations()->get()),
            'assignments' => WorkshopAssignmentResource::collection($user->assignments()->with('workshop')->get()),
        ]);
    }

    // delete method to remove a user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
