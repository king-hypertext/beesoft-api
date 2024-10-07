<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrgParentResource;
use App\Models\Organization;
use App\Models\OrgParent;
use App\Models\User;
use App\Models\UserAccountStatus;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        if ($user->user_role !== 'admin') {
            abort(403, 'You must be an administrator');
        }
        // $org = Organization::query()->firstWhere('user_id', $id);
        // $data = OrgParent::query()->where('organization_id', $org->id);
        return OrgParentResource::collection($user->organization->org_parent);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;
        $org_id = $user->organization->id;
        if ($user->user_role !== 'admin') {
            abort(403, 'You must be an administrator');
        }
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|numeric',
            'user_id' => 'required|exists:users,id,' . $user_id,
            'organization_id' => 'required|exists:organizations,id'
        ], []);
        $data = OrgParent::create($request->all());
        User::create([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|numeric',
            'role' => UserRole::query()->firstWhere('role', 'parent')->id,
            'account_status' => UserAccountStatus::query()->firstWhere('account_status', 'active')->id,
            'fullname' => $request->name,
        ]);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrgParent $orgParent)
    {
        return OrgParentResource::collection($orgParent->load('children', 'delegates')->loadCount('children'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrgParent $orgParent)
    {
        $request->validate([], []);
        $orgParent->update([]);
        return response()->json(
            [
                'success' => true,
                'data' => $orgParent->fresh(['children'])
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrgParent $orgParent)
    {
        $orgParent->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully removed the specified data'
        ]);
    }
}
