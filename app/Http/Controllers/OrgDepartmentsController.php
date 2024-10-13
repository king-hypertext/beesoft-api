<?php

namespace App\Http\Controllers;

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
        $organization = Auth::user()->organization;

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $departments = $organization->departments;

        if ($departments->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No departments found for this organization',
                'departments_count' => 0,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $departments,
            'departments_count' => $departments->count(),
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $organization = Auth::user()->organization;

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $department = $organization->departments()->create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'data' => $department,
        ], 201);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $org = Auth::user()->organization;
        if (!$org) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }
        $department = $org->departments->find($id);
        if (!$department) {
            return response()->json([
                'message' => 'Department not found or does not belong to this organization',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $department
        ], 302);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrgDepartments $orgDepartments)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgDepartments $department)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        // Check organization existence
        $organization = Auth::user()->organization;
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }
        if (!$department || !$organization->departments->contains($department)) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found or does not belong to this organization',
            ], 404);
        }

        // Update department
        $department->update($validatedData);

        // Return updated department
        return response()->json([
            'success' => true,
            'data' => $department->fresh(),
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgDepartments $department)
    {
        $organization = Auth::user()->organization;

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        if (!$organization->departments->contains($department)) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found or does not belong to this organization',
            ], 403);
        }

        $department->delete();

        return response()->noContent(204);
    }
}
