<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\ParentDelegate;
use Illuminate\Http\Request;

class ParentDelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data'=> ParentDelegate::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([],[]);
        $parentDelegate = parentDelegate::create($request->all());
        return response()->json([
            'data'=> $parentDelegate
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data'=> parentDelegate::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([],[]);
        $parentDelegate = parentDelegate::find($id);
        $parentDelegate->update($request->all());
        return response()->json([
            'data'=> $parentDelegate->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        parentDelegate::destroy($id);
        return response()->noContent();
    }
}
