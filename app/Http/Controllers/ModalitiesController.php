<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreModalitiesRequest;
use App\Http\Requests\Update\UpdateModalitiesRequest;
use App\Http\Resources\ModalitiesResource;
use App\Models\Modalities;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ModalitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $modalities = Modalities::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        })
            ->get();

        return ModalitiesResource::collection($modalities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModalitiesRequest $request)
    {
        $validated = $request->validated();

        Modalities::create($validated);

        return response()->json([
            'message' => 'Modality created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Modalities $modality)
    {
        return new ModalitiesResource($modality);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModalitiesRequest $request, Modalities $modality)
    {
        $validated = $request->validated();
        $modality->update($validated);

        return new ModalitiesResource($modality);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modalities $modality)
    {
        $modality->delete();

        return response()->json([
            'message' => 'Modality deleted successfully',
        ], 200);
    }

    public function destroyMany(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:modalities,id',
            ]);

            Modalities::destroy($validated['ids']);

            return response()->json([
                'message' => 'Modalities deleted successfully',
            ], 200);
        } catch (ValidationException $error) {
            return response()->json([
                'message' => 'Some IDs do not exist in database',
                'error' => $error->errors(),
            ], 422);
        }
    }
}
