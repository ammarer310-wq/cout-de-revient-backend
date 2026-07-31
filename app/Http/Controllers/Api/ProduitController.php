<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Produit::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'nom'=>'required',
        'grammage'=>'required|numeric|min:1',
        'rendement'=>'required|numeric|min:0|max:100',
        'temps_production'=>'required|integer|min:1'
    ]);

    return Produit::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        return $produit;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
        'nom'=>'required',
        'grammage'=>'required|numeric|min:1',
        'rendement'=>'required|numeric|min:0|max:100',
        'temps_production'=>'required|integer|min:1'
    ]);

    $produit->update($validated);

    return $produit;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
         $produit->delete();

    return response()->json([
        'message'=>'Produit supprimé'
    ]);
    }
}
