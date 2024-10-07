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
        $org = Organization::firstWhere(['user_id' => $user->id]);
        return response()->json([
            'success' => true,
            'user' => $user,
            'data' => $org !== null ?  OrganizationResource::collection($org->with('category', 'accout_status')) : 'no data available'
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
        $id = Auth::id();
        $user = User::find($id);
        // $org = Organization::query()->firstWhere('user_id', $auth_user->id);

        return response()->json([
            'success' => true,
            'data' => OrganizationResource::collection($user->organization()->with('category', 'accout_status'))
        ]);
        //
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
