<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreOrganizationRequest;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Http\Request;

class ManageOrganization extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Organization::all();
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {
        $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('/images', 'public');
        }
        $organization = Organization::create([
            'name' => $request->name,
            'post_office_address' => $request->post_office_address,
            'image' => $image ?? null,
            'user_id' => $request->admin,
            'category_id' => $request->category,
            'email' => $request->email,
            'activated_by' => $request->user()->id,
            'sms_api_key' => $request->sms_api_key,
            'sms_api_secret_key' => $request->sms_api_secret_key,
            'sms_provider' => $request->sms_provider,
            'manage_clock_in' => $request->manage_clock_in ?? 0,
            'signature_clock_in' => $request->signature_clock_in ?? 0,
            'account_status' => $request->account_status,
        ]);
        if ($request->has('phone')) {
            // Save phone number to organization_phones table and associate with organization
            $organization->phone_numbers()->create(['phone_number' => $request->phone]);
        }
        if ($request->has('community')) {
            $organization->location()->create([
                'community' => $request->community,
                'city_id' => $request->city,
                'district_id' => $request->district
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $organization
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $organization
        ], 302);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        dd($organization);
        $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('/images', 'public');
        }
        $organization = Organization::create([
            'name' => $request->name,
            'post_office_address' => $request->post_office_address,
            'image' => $image ?? null,
            'user_id' => $request->admin,
            'category_id' => $request->category,
            'email' => $request->email,
            'activated_by' => $request->user()->id,
            'sms_api_key' => $request->sms_api_key,
            'sms_api_secret_key' => $request->sms_api_secret_key,
            'sms_provider' => $request->sms_provider,
            'manage_clock_in' => $request->manage_clock_in ?? 0,
            'signature_clock_in' => $request->signature_clock_in ?? 0,
            'account_status' => $request->account_status,
        ]);
        if ($request->has('phone')) {
            // Save phone number to organization_phones table and associate with organization
            $organization->phone_numbers()->create(['phone_number' => $request->phone]);
        }
        if ($request->has('community')) {
            $organization->location()->create([
                'community' => $request->community,
                'city_id' => $request->city,
                'district_id' => $request->district
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $organization
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        // $organization->dd();
        // dd($organization);
        $organization->delete();
        return response()->noContent();
    }
}
