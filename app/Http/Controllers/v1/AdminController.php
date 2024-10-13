<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(404);
    }

    /**
     * Display the resource.
     */
    public function show()
    {

        $user = request()->user();
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        abort(404);
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:255|unique:users,phone_number,' . $user->id,
            'image' => 'nullable|file|mimes:png,jpg,jpeg,webp'
        ]); 

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('users/images', 'public');
        }

        $user->update([
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'image' => $validatedData['image'] ?? $user->image,
        ]);

        return response()->json([
            'success' => true,
            'data' => $user->fresh(),
        ]);
    }


    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(403);
    }
}
