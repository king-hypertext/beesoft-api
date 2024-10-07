<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrgDepartments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgDepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OrgDepartments::where('organization_id', '=', Organization::firstWhere('user_id', Auth::id())->id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description',
            'purpose'
        ]);
        $dep = OrgDepartments::create([
            'organization_id' => Organization::firstWhere('user_id', Auth::id())->id,
            'name' => $request->name,
            'description' => $request->description ?? null,
            'purpose' => $request->purpose ?? null,
        ]);
        return response()->json([
            'success' => true,
            'data' => $dep
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrgDepartments $orgDepartments)
    {
        if (!$orgDepartments) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $orgDepartments
        ], 302);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrgDepartments $orgDepartments)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgDepartments $orgDepartments)
    {
        $request->validate([
            'name' => 'required',
            'description',
            'purpose'
        ]);
        $orgDepartments->update([
            'organization_id' => Organization::firstWhere('user_id', Auth::id())->id,
            'name' => $request->name,
            'description' => $request->description ?? null,
            'purpose' => $request->purpose ?? null,
        ]);
        return response()->json([
            'success' => true,
            'data' => $orgDepartments->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgDepartments $orgDepartments)
    {
        $orgDepartments->delete();
        return response()->noContent();
    }
}
