<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recette;

class RecetteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Recette::with(
        'produit',
        'matierePremiere'
    )->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated =
        $request->validate([

        'produit_id' =>
            'required|exists:produits,id',

        'matierepremiere_id' =>
            'required|exists:matierepremieres,id',

        'quantite_theorique' =>
            'required|numeric|min:0',

        'perte_pourcentage' =>
            'nullable|numeric|min:0|max:100',

        'rendement' =>
            'nullable|numeric|min:1|max:100'
    ]);

    $quantiteReelle =
        $validated['quantite_theorique'];

    $perte =
        $validated['perte_pourcentage']
        ?? 0;

    $rendement =
        $validated['rendement']
        ?? 100;

    $quantiteReelle =
        $quantiteReelle *
        (1 + $perte / 100);

    $quantiteReelle =
        $quantiteReelle /
        ($rendement / 100);

    $validated[
        'quantite_reelle'
    ] =
        round(
            $quantiteReelle,
            2
        );

    return Recette::create(
        $validated
    );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Recette::with(
        'produit',
        'matierePremiere'
    )->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $recette =
        Recette::findOrFail($id);

    $validated =
        $request->validate([

        'produit_id' =>
            'required|exists:produits,id',

        'matierepremiere_id' =>
            'required|exists:matierepremieres,id',

        'quantite_theorique' =>
            'required|numeric|min:0',

        'perte_pourcentage' =>
            'nullable|numeric|min:0|max:100',

        'rendement' =>
            'nullable|numeric|min:1|max:100'
    ]);

    $quantite =
        $validated[
            'quantite_theorique'
        ];

    $perte =
        $validated[
            'perte_pourcentage'
        ] ?? 0;

    $rendement =
        $validated[
            'rendement'
        ] ?? 100;

    $validated[
        'quantite_reelle'
    ] =
        round(
            ($quantite *
             (1 + $perte/100))
             /
             ($rendement/100),
            2
        );

    $recette->update(
        $validated
    );

    return $recette;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    Recette::findOrFail($id)
            ->delete();

    return response()->json([
        'message' =>
            'Recette supprimée'
    ]);
    }
}
