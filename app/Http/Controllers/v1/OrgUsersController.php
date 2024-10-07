<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\OrgUser;
use Illuminate\Http\Request;

class OrgUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OrgUser::all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'full_name' => 'required|string',
            'email' => 'nullable|email',
            'mum_phone' => 'required|numeric',
            'dad_phone' => 'required|numeric',
            'department_id' => 'required|exists:org_departments,id',
            'gender' => 'required',
            'parental_action' => 'required',
            // 'voice',
        ]);
        $voice = '';
        $data = OrgUser::create([
            'organization_id' => $request->user()->organization->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'mum_phone' => $request->mum_phone,
            'dad_phone' => $request->dad_phone,
            'department_id' => $request->department,
            'gender' => $request->gender,
            'parental_action' => $request->parental_action,
            'voice' => $voice,
        ]);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrgUser $orgUser)
    {
        if (!$orgUser) {
            return response()->json([
                'error' => true,
                'message' => 'User does not exist'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $orgUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgUser $orgUser)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'full_name' => 'required|string',
            'email' => 'nullable|email',
            'mum_phone' => 'required|numeric',
            'dad_phone' => 'required|numeric',
            'department_id' => 'required|exists:org_departments,id',
            'gender' => 'required',
            'parental_action' => 'required',
            // 'voice',
        ]);
        $voice = '';
        $orgUser->update([
            'organization_id' => $request->user()->organization->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'mum_phone' => $request->mum_phone,
            'dad_phone' => $request->dad_phone,
            'department_id' => $request->department,
            'gender' => $request->gender,
            'parental_action' => $request->parental_action,
            'voice' => $voice,
        ]);
        return response()->json([
            'success' => true,
            'data' => $orgUser->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgUser $orgUser)
    {
        $orgUser->delete();
        return response()->noContent();
    }
}
