<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\WorkshopAssignmentRequest;
use App\Http\Resources\UserSelectResource;
use App\Http\Resources\WorkshopSelectResource;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopAssignment;

class WorkshopAssignmentController extends Controller
{
    public function create()
    {
        $workshops = Workshop::available()->get();

        return inertia('Assignments/Create', [
            'workshops' => WorkshopSelectResource::collection($workshops),
            'users' => UserSelectResource::collection(User::orderBy('name')->get()),
            'roles' => collect(Role::cases())->map(fn (Role $role) => [
                'label' => str_replace('_', ' ', $role->name),
                'value' => $role->value,
            ]),
            'user_id' => request()->query('user_id'),
            'workshop_id' => request()->query('workshop_id'),
        ]);
    }

    public function store(WorkshopAssignmentRequest $request)
    {
        $data = $request->validated();

        WorkshopAssignment::create([
            'user_id' => $data['user_id'],
            'workshop_id' => $data['workshop_id'],
            'role' => $data['role'],
        ]);

        return redirect()->route('workshops.show', $data['workshop_id'])
            ->with('success', 'Assignment created successfully.');
    }

    public function destroy(WorkshopAssignment $assignment)
    {
        $workshopId = $assignment->workshop_id;
        $assignment->delete();

        return redirect()->route('workshops.show', $workshopId)
            ->with('success', 'Assignment removed successfully.');
    }
}
