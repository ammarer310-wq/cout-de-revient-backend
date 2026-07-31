<?php

namespace App\Services;

class PricingService
{
    public function calculer(
        $coutUnitaire,
        $prixVente
    )
    {
        $margeBrute =
            $prixVente - $coutUnitaire;

        $tauxMarge =
            ($margeBrute /$prixVente)
            * 100;

        $prixMinimum =
            $coutUnitaire * 1.20;

        return [

            'cout_unitaire' =>
                round($coutUnitaire,2),

            'prix_vente' =>
                round($prixVente,2),

            'marge_brute' =>
                round($margeBrute,2),

            'taux_marge' =>
                round($tauxMarge,2),

            'prix_min_conseille' =>
                round($prixMinimum,2)
        ];
    }
}