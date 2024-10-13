<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrgDepartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgDepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $org = Auth::user()->organization;

        if (!$org) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $data = $org->departments;

        if (!$data->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No departments found for this organization',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $organization = Auth::user()->organization;
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'No data found',
            ], 404);
        }

        $dep = OrgDepartments::create([
            'organization_id' => $organization->id,
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'data' => $dep,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id, OrgDepartments $orgDepartments)
    {
        $department = $orgDepartments->find($id);
        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }
        $org = Organization::firstWhere('user_id', Auth::id());
        if (!$org) {
            return response()->json([
                'message' => 'You are not allowed to view this resource',
            ], 403);
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
        $request->validate([
            'name' => 'required',
            'description',
            'purpose'
        ]);
        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }
        $org = Organization::firstWhere('user_id', Auth::id());
        if (!$org) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',
            ], 403);
        }
        $department->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);
        return response()->json([
            'success' => true,
            'data' => $department->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgDepartments $department)
    {
        $org = Organization::firstWhere('user_id', Auth::id());
        if (!$org) {
            return response()->json([
                'message' => 'You are not allowed to perform this action',
            ], 403);
        }
        $department->delete();
        return response()->noContent();
    }
}
