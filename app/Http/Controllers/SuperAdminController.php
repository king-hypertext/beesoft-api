<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return request()->user();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // return $request->user();
        $user = request()->user();
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:255|unique:users,phone_number,' . $user->id,
            'image' => 'nullable|file|mimes:png,jpg,jpeg,webp'
        ], [
            'email.unique' => 'The provided email is already in use.',
            'phone_number.unique' => 'The provided phone number is already in use.',
            'image.mimes' => 'The image must be a file of type: png, jpg, jpeg, webp.',
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
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
