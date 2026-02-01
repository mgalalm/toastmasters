<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\SpeechResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkshopAssignmentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index method to list all users
    public function index(Request $request)
    {
        $roles = Arr::wrap($request->input('roles', []));
        $roleMode = $request->string('role_mode')->toString();
        $active = $request->input('active');

        if (! in_array($active, ['0', '1'], true)) {
            $active = null;
        }

        $users = User::orderBy('active', 'desc')
            ->orderBy('name', 'asc')
            ->with(['assignments', 'speeches'])
            ->roleFilter($roleMode, $roles)
            ->activeFilter($active)
            ->paginate(16)
            ->withQueryString();

        return inertia('Users/Index', [
            'users' => UserResource::collection($users),
            'filters' => [
                'role_mode' => $roleMode ?: null,
                'roles' => $roles,
                'active' => $active,
            ],
        ]);
    }

    public function create()
    {
        return inertia('Users/Create');
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'profile_photo_path' => $data['profile_photo_path'] ?: null,
            'active' => $data['active'],
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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

    public function edit(User $user)
    {
        return inertia('Users/Create', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'active' => (bool) $user->active,
                'profile_photo_path' => $user->profile_photo_path,
            ],
            'isEdit' => true,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'active' => $data['active'],
            'profile_photo_path' => $data['profile_photo_path'] ?: null,
            ...($request->filled('password') ? ['password' => Hash::make($data['password'])] : []),
        ]);

        return redirect()->route('users.show', $user)->with('success', 'User updated successfully.');
    }

    // delete method to remove a user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
