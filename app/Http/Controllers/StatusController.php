<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreStatusRequest;
use App\Http\Requests\Update\StatusUpdateRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StatusResource::collection(Status::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        $validated = $request->validated();

        Status::create($validated);

        return response()->json([
            'message' => 'Status created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusUpdateRequest $request, Status $status)
    {
        $validated = $request->validated();
        $status->update($validated);

        return new StatusResource($status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
