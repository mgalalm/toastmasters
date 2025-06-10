<?php

namespace App\Http\Controllers;

use App\Enums\PathWay;
use App\Http\Requests\SpeechRequest;
use App\Http\Resources\SpeechResource;
use App\Models\Speech;
use Illuminate\Http\Request;

class SpeechController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

        return inertia('Speeches/Create', [
            'pathways' => PathWay::allPathways(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpeechRequest $request)
    {
        $data = $request->validated();

        $request->user()->speeches()->create([
            ...$data,
        ]);

        return redirect()->route('speeches.index')->with('success', 'Speech created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Speech $speech)
    {

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
        // return the speech as a resource to inertia
        return inertia('Speeches/Create', [
            'speech' => new SpeechResource($speech),
            'pathways' => PathWay::allPathways(),
            'isEdit' => true,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpeechRequest $request, Speech $speech)
    {

        $data = $request->validated();

        $speech->update([
            ...$data,
        ]);

        return to_route('speeches.index')
            ->banner("Speech {$speech->title} has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speech $speech)
    {
        $speech->delete();

        return to_route('speeches.index')
            ->banner("Speech {$speech->title} has been deleted successfully.");
    }
}
