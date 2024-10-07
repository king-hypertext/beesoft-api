<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ManageAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        Gate::authorize('viewAny');
        return UserResource::collection(User::with(['user_settings', 'user_role']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'phone_number' => 'required|numeric',
            'role' => 'required|exists:user_roles,id',
            'fullname' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,webp,bmp|max:2048',
            'account_status' => 'required|exists:account_status,id',
        ], [
            'phone_number.numeric' => 'the provided phone number is not valid'
        ]);
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return UserResource::collection($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'nullable|email',
            'phone_number' => 'required|numeric',
            'role' => 'required|exists:user_roles,id',
            'fullname' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,webp,bmp|max:2048',
            'account_status' => 'required|exists:account_status,id',
        ], [
            'phone_number.numeric' => 'the provided phone number is not valid'
        ]);
        $user->update([]);
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user->fresh(['user_settings', 'user_role']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
