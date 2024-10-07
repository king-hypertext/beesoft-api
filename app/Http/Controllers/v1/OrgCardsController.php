<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrgCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Card::where('organization_id', '=', Organization::firstWhere('user_id', Auth::id())->id);
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
            'card_number' => 'required',
            'organization_id' => 'required',
            'org_user_id' => 'required',
        ]);
        $card = Card::create([
            'card_number' => $request->card_number,
            'org_user_id' => $request->org_user_id,
            'organization_id' => Organization::firstWhere('user_id', Auth::id())->id,
            'card_status' => 1,
        ]);
        return response()->json([
            'succeed' => true,
            'card' => $card
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        if (!$card) {
            return response()->json([
                'message' => 'Card not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $card
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        $request->validate([
            'card_number' => 'required',
            'organization_id' => 'required',
            'org_user_id' => 'required',
        ]);
        $card->update([
            'card_number' => $request->card_number,
            'org_user_id' => $request->org_user_id,
            'organization_id' => Organization::firstWhere('user_id', Auth::id())->id,
            'card_status' => $request->card_status,
        ]);
        return response()->json([
            'succeed' => true,
            'card' => $card->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->delete();
        return response()->noContent();
    }
}
