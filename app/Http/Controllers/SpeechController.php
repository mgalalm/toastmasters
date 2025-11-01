<?php

namespace App\Http\Controllers;

use App\Enums\PathWay;
use App\Http\Requests\SpeechRequest;
use App\Http\Resources\SpeechResource;
use App\Http\Resources\UserSelectResource;
use App\Http\Resources\WorkshopSelectResource;
use App\Models\Speech;
use App\Models\Workshop;
use Illuminate\Http\Request;

class SpeechController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Speech::latest('id');

        if (! $request->user()->is_admin) {
            $query->where('user_id', $request->user()->id);
        }

        $speeches = $query->paginate(5);

        return inertia('Speeches/Index', [
            'speeches' => SpeechResource::collection($speeches),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $workshops = Workshop::available()->get();
        $workshopId = $request->query('workshop_id');
        $speakerId = $request->user()->id;

        return inertia('Speeches/Create', [
            'pathways' => PathWay::cases(),
            'workshops' => WorkshopSelectResource::collection($workshops),
            'workshop_id' => $workshopId,
            'users' => UserSelectResource::collection($request->user()->all()),
            'speaker_id' => $speakerId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpeechRequest $request)
    {
        $data = $request->validated();

        // dd($data);
        Speech::create([
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
        $speech->load(['speaker', 'evaluator', 'workshop:id,title']);

        // dd($speech->workshop->ge);
        return inertia('Speeches/Show', [
            'speech' => new SpeechResource($speech),
            // 'workshop' => $speech->workshop?->title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Speech $speech, Request $request)
    {
        // return the speech as a resource to inertia
        $workshops = Workshop::available()->get();

        return inertia('Speeches/Create', [
            'speech' => new SpeechResource($speech),
            'pathways' => PathWay::cases(),
            'workshops' => WorkshopSelectResource::collection($workshops),
            'isEdit' => true,
            'users' => UserSelectResource::collection($request->user()->all()),
            'workshop_id' => $speech->workshop_id,
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
