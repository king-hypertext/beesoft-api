<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Card;
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
        if ($data->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No Users found.'
            ], 404);  // Return HTTP status code 404 Not Found if no OrgUsers found. 400 Bad Request if validation fails. 201 Created if successful. 200 OK if successful. 401 Unauthorized if not authenticated. 403 Forbidden if not authorized. 422 Unprocessable Entity if validation fails. 500 Internal Server Error if server error. 503 Service Unavailable if server is temporarily unavailable. 504 Gateway Timeout if server is temporarily unavailable. 550 Insufficient Storage if server is temporarily unavailable. 599 Client Timeout Error if server is temporarily unavailable. 600 Unavailable for Legal Reasons if server is temporarily unavailable. 601 Web Application Firewall (WAF) Firewall Denied
        }
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
    public function LinkCard($id, Request $request)
    {
        $orgUser = OrgUser::find($id);
        if (!$orgUser) {
            return response()->json([
                'error' => true,
                'message' => 'User does not exist'
            ], 404);
        }
        $card = Card::firstOrCreate(['card' => $request->card]);
        if (!$card) {
            return response()->json([
                'error' => true,
                'message' => 'Card does not exist'
            ], 404);
        }
        $orgUser->card_id = $request->card->id;
        $orgUser->save();
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
