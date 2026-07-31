<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoriquePrix;
use App\Models\MatierePremiere;

class HistoriquePrixController extends Controller
{
    public function index()
{
    return HistoriquePrix::with(
        'matierePremiere'
    )->get();
}

public function store(Request $request)
{
    $validated =
        $request->validate([

        'matierepremiere_id' =>
            'required|exists:matierepremieres,id',

        'prix' =>
            'required|numeric|min:0',

        'date_prix' =>
            'required|date'
    ]);

    $historique =
        HistoriquePrix::create(
            $validated
        );

    /*
       mettre à jour
       le prix actuel
    */

    $matiere =
        MatierePremiere::find(
            $validated['matierepremiere_id']
        );

    $matiere->update([
        'prix_achat' =>
            $validated['prix']
    ]);

    return $historique;
}

public function show(
    HistoriquePrix $historiquePrix
)
{
    return $historiquePrix;
}

public function update(
    Request $request,
    HistoriquePrix $historiquePrix
)
{
    $validated =
        $request->validate([

        'prix' =>
            'required|numeric|min:0',

        'date_prix' =>
            'required|date'
    ]);

    $historiquePrix->update(
        $validated
    );

    return $historiquePrix;
}

public function destroy(
    HistoriquePrix $historiquePrix
)
{
    $historiquePrix->delete();

    return response()->json([
        'message' =>
            'Prix supprimé'
    ]);
}


   
}
