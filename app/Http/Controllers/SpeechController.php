<?php

namespace App\Http\Controllers;

use App\Enums\PathWay;
use App\Http\Resources\SpeechResource;
use App\Models\Speech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SpeechController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // fetch all speeches and return as a resource collection to inertia

        Gate::authorize('viewAny', Speech::class);

        $speeches = $request->user()->speeches()->latest('id')->paginate();

        return inertia('Speeches/Index', [
            'speeches' => SpeechResource::collection($speeches),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return inertia view for creating a new speech
        Gate::authorize('create', Speech::class);

        return inertia('Speeches/Create', [
            'pathways' => PathWay::allPathways(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'length' => 'required|integer|min:1',
            'objectives' => 'required',
            'evaluator_notes' => 'nullable|string',
            'pathway' => 'required',
        ]);

        $request->user()->speeches()->create([
            'title' => $data['title'],
            'length' => $data['length'],
            'objectives' => $data['objectives'],
            'evaluator_notes' => $data['evaluator_notes'],
            'pathway' => $data['pathway'],
        ]);

        return redirect()->route('speeches.index')->with('success', 'Speech created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Speech $speech)
    {
        // authorize the user to view the speech
        Gate::authorize('view', $speech);

        // return the speech as a resource to inertia
        return inertia('Speeches/Show', [
            'speech' => new SpeechResource($speech),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Speech $speech)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speech $speech)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speech $speech)
    {
        //
    }
}
