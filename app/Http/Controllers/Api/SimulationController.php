<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CostEngine;

class SimulationController extends Controller
{
    public function calcul(
        Request $request
    )
    {
        $prix =
            $request->prix_vente;

        $volume =
            $request->volume;

        $cout =
            80;

        $benefice =
            $prix
            -
            $cout;

        $beneficeTotal =
            $benefice
            *
            $volume;

        return response()->json([

            'cout' => $cout,

            'benefice_unitaire'
                =>
                $benefice,

            'benefice_total'
                =>
                $beneficeTotal
        ]);
    }

    public function simuler(
        Request $request,
        CostEngine $engine
    )
    {
        $resultat =
            $engine->calculerParams(

                $request->recettes,

                $request->cout_mod,

                $request->cout_packaging,

                $request->charges_indirectes,

                $request->quantite_lot
            );

        return response()->json(
            $resultat
        );
    }
}