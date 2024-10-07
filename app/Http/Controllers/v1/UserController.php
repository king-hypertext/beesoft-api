<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view');
        return $user;
    }

    public function storeImage(int $id, Request $request, User $auth)
    {
        $user = $auth->query()->find($id);

        if (!$user) {
            abort(404, 'user not found');
        }
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,webp,bmp|max:2048',
            ], [
                'image.max' => 'the maximum image size for upload must not exceed 2MB',
            ]);
            $image = $request->file('image')->store('/images', 'public');
            $user->update([
                'id' => $user->employer->id,
                'image' => '/storage/images/' . $image
            ]);
            return response()->json([
                'success' => true,
                'image' => url($image)
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => null,
        ], 403);
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
        ], []);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,webp,bmp|max:2048',
            ]);
        }
        $image = $request->file('image')->store('/images', 'public');
        $user->update([
            'image' => $request->hasFile('image') ? $image : null,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'fullname' => $request->fullname,
            'account_status' => $request->account_status,
            'role' => $request->role,
        ]);
        return $user->fresh(['user_role', 'user_settings', 'isSuperAdmin']);
    }
}
