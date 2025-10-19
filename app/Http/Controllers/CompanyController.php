<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreCompanyRequest;
use App\Http\Requests\Update\UpdateCompnayRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::when($request->search, function ($query) use ($request) {
            $query->Where('name', 'like', '%'.$request->search.'%');
        })
            ->paginate(10);

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        Company::create($validated);

        return response()->json([
            'message' => 'Company created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompnayRequest $request, Company $company)
    {
        $validated = $request->validated();
        $company->update($validated);

        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully',
        ]);
    }
}
