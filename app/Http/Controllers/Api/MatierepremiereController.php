<?php

namespace App\Http\Controllers\Api;
use App\Models\MatierePremiere;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatierepremiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MatierePremiere::with('fournisseur')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

        'nom' => 'required',

        'prix_achat' => 'required|numeric|min:0',

        'unite' => 'required',

        'fournisseur_id' =>
            'nullable|exists:fournisseurs,id'
    ]);

    return MatierePremiere::create(
        $validated
    );
    }

    /**
     * Display the specified resource.
     */
    public function show(MatierePremiere $matiere)
    {
        return $matiere->load(
        'historiquesPrix',
        'fournisseur'
    );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MatierePremiere $matiere
)
{
    $validated = $request->validate([

        'nom' => 'required',

        'prix_achat' =>
            'required|numeric|min:0',

        'unite' => 'required',

        'fournisseur_id' =>
            'nullable|exists:fournisseurs,id'
    ]);

    $matiere->update($validated);

    return $matiere;
}
    
        //
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatierePremiere $matiere
)
{
    $matiere->delete();

    return response()->json([
        'message' =>
            'Matière supprimée'
    ]);
}
}
