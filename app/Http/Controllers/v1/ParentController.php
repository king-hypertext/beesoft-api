<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChildrenResource;
use App\Models\Children;
use App\Models\User;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): never
    {
        abort(302);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(302);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user) {
            return response()->json([
                'data' => $user->with(['children', 'delegates', 'organization'])->withCount('delegates', 'children', 'organization'),
                'message' => 'User retrieved successfully'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'User not found',
            'additional_info' => 'User not authenticated'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([], []);
        $user->update([]);
        return response()->json([
            'data' => $user->fresh(['children', 'delegates', 'organization'])->loadCount('delegates', 'children', 'organization'),
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): never
    {
        abort(302);
    }
    public function children(User $user)
    {
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'found no children',
                'additional_info' => 'User not authenticated'
            ], 404);
        }
        if($user->children()->count() == 0) {
            return response()->json([
                'success' => true,
                'message' => 'No children found for this user',
            ], 200);
        }
        return ChildrenResource::collection($user->children()->with('organization', 'department')->get());
    }
    public function child($child)
    {
        $data = Children::with(['organization', 'department'])->find($child);
        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'Child not found',
                'additional_info' => 'User not authenticated'
            ], 404);
        }
        return ChildrenResource::collection($data);
    }
}
