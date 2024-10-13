<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Organization;
use App\Models\OrgUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgUsersController extends Controller
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

        $users = OrgUser::where('organization_id', $organization->id)->get();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,  // Changed to false to indicate failure
                'message' => 'No users found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $users,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $organization = Auth::user()->organization;

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'department_id' => 'required|exists:org_departments,id',
            'full_name' => 'required|string',
            'email' => 'nullable|email',
            'date_of_birth' => 'required|date',
            'mum_phone' => 'nullable|numeric',
            'dad_phone' => 'nullable|numeric',
            'gender' => 'required|in:1,2',
            'parental_action' => 'nullable|string',
            'voice' => 'nullable|file|mimes:audio',
        ]);

        if ($request->hasFile('voice')) {
            $validatedData['voice'] = $request->file('voice')->store('org/users/voice', 'public');
        }

        $orgUser = OrgUser::create([
            'organization_id' => $organization->id,
            'department_id' => $validatedData['department_id'],
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'mum_phone' => $validatedData['mum_phone'],
            'dad_phone' => $validatedData['dad_phone'],
            'gender' => $validatedData['gender'],
            'parental_action' => $validatedData['parental_action'],
            'voice' => $validatedData['voice'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => $orgUser,
        ], 201);
    }



    /**
     * Display the specified resource.
     */

    public function show(int $id)
    {
        $organization = Auth::user()->organization;

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $user = $organization->users()->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist or does not belong to this organization',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }


    public function linkCard(int $user_id, Request $request)
    {
        $request->validate([
            'card_number' => 'required|numeric|exists:cards,card_number',
            // 'organization_id'=> 'required|exists:organizations,id'
        ], [
            'card_number.required' => 'Card number is required',
            'card_number.numeric' => 'Card number must be numerical',
            'card_number.exists' => 'Card does not exist',
            // 'organization_id.required' => 'Organization ID is required',
            // 'organization_id.exists' => 'Organization ID does not exist'
            // 'organization_id.required' => 'Organization ID is required',
            // 'organization_id.exists' => 'Organization ID does not exist'
        ]);

        $organization = Auth::user()->organization;

        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found',
            ], 404);
        }

        $user = $organization->users->find($user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist or does not belong to this organization',
            ], 404);
        }

        $card = Card::firstWhere(['card_number' => $request->card_number,/*  'organization_id' => $organization->id */]);

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'Card does not exist',
            ], 404);
        }

        if ($card->org_user_id && $card->org_user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Card already linked to another user',
            ], 400);
        }

        $card->update([
            'org_user_id' => $user_id,
            'organization_id' => $organization->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Card linked successfully',
            // 'data' => $user,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgUser $user)
    {
        $validatedData = $request->validate([
            'department_id' => 'required|exists:org_departments,id',
            'full_name' => 'required|string',
            'email' => 'nullable|email',
            'date_of_birth' => 'required|date',
            'mum_phone' => 'nullable|numeric',
            'dad_phone' => 'nullable|numeric',
            'gender' => 'required|in:1,2',
            'parental_action' => 'nullable|string',
            'voice' => 'nullable|file|mimes:audio',
        ]);
        $organization = $request->user()->organization;

        if (!$organization || !$organization->users->contains($user)) {
            return response()->json([
                'success' => false,
                'message' => 'User does not belong to this organization',
            ], 403);
        }


        if ($request->hasFile('voice')) {
            $validatedData['voice'] = $request->file('voice')->store('org/users/voice', 'public');
        } else {
            $validatedData['voice'] = $user->voice;
        }

        $user->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $user->fresh(),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgUser $user)
    {
        // return $user;

        $organization = Auth::user()->organization;

        if (!$organization || !$organization->users->contains($user)) {
            return response()->json([
                'success' => false,
                'message' => 'you are not allowed to perform this action.',
            ], 403);
        }
        $user->delete();
        return response()->noContent();
    }
}
