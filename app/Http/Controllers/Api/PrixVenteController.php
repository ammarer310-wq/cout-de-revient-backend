<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoriquePrixVente;
use App\Models\Produit;

class PrixVenteController extends Controller
{
     public function enregistrer(Request $request, $id)
    {
        // Verifie que le produit existe (sinon 404 automatique)
        Produit::findOrFail($id);

        $prixVente = $request->input('prix_vente');

        if (!is_numeric($prixVente) || $prixVente < 0) {
            return response()->json([
                'message' => 'Le champ prix_vente est requis et doit etre un nombre positif.',
            ], 422);
        }

        $historique = HistoriquePrixVente::create([
            'produit_id' => $id,
            'prix_vente' => $prixVente,
        ]);

        return response()->json($historique, 201);
    }
}
