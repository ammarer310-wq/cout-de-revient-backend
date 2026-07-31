<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fournisseur;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Fournisseur::all();
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'email' => 'nullable|email',
            'telephone' => 'nullable',
            'adresse' => 'nullable'
        ]);

        return Fournisseur::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Fournisseur::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fournisseur = Fournisseur::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required',
            'email' => 'nullable|email',
            'telephone' => 'nullable',
            'adresse' => 'nullable'
        ]);

        $fournisseur->update($validated);

        return $fournisseur;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Fournisseur::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Fournisseur supprimé'
        ]);
    }
}
