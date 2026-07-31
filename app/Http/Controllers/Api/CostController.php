<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoriqueCout;
use App\Services\CostEngine;

class CostController extends Controller
{
    public function calcul(
        Request $request,
        $id,
        CostEngine $engine
    ) {
        $quantiteProduite = (float) $request->query('quantite', 1000);

        $resultat = $engine->calculer($id, $quantiteProduite);

        HistoriqueCout::create([
            'produit_id' => $id,
            'cout_matieres' => $resultat['cout_matieres'],
            'cout_main_oeuvre' => $resultat['cout_main_oeuvre'],
            'cout_packaging' => $resultat['cout_packaging'],
            'charges_indirectes' => $resultat['chargesindirectes'],
            'cout_total' => $resultat['cout_total'],
            'cout_unitaire' => $resultat['cout_unitaire'],
            'quantite_produite' => $resultat['quantite_produite_utilisee'],
        ]);

        return response()->json($resultat);
    }
}