<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreContractRequest;
use App\Http\Requests\Update\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contracts = Contract::when($request->has('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        })
            ->get();

        return ContractResource::collection($contracts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        $validated = $request->validated();
        Contract::create($validated);

        return response()->json([
            'message' => 'Contract created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return new ContractResource($contract);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $validated = $request->validated();
        $contract->update($validated);

        return new ContractResource($contract);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return response()->json([
            'message' => 'Contract deleted successfully',
        ]);
    }
}
