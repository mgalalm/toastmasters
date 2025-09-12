<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeechResource;
use App\Http\Resources\WorkshopAssignmentResource;
use App\Http\Resources\WorkshopResource;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workshops = Workshop::orderByRaw('CAST(SUBSTRING_INDEX(title, " ", -1) AS UNSIGNED) ASC')->paginate(10);

        return inertia('Workshops/Index', [
            'workshops' => WorkshopResource::collection($workshops),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Workshop $workshop)
    {
        $workshop->load(['assignments', 'speeches']);

        return inertia('Workshops/Show', [
            'workshop' => new WorkshopResource($workshop),
            'assignments' => fn () => WorkshopAssignmentResource::collection($workshop->assignments()->with('user')->orderByRaw("
        CASE role
            WHEN 'president' THEN 1
            WHEN 'TOAST_MASTER' THEN 2
            WHEN 'TOPICS_MASTER' THEN 3
            ELSE 99
        END
    ")->get()),
            'speeches' => fn () => SpeechResource::collection($workshop->speeches()->with(['speaker', 'evaluator'])->get()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workshop $workshop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
        //
    }
}
