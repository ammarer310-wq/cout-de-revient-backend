<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;

class DashboardController extends Controller
{
    public function index()
    {
        $produits = Produit::with(['historiqueCouts', 'historiquePrixVentes'])->get();

        $nbProduits = $produits->count();

        $donnees = $produits->map(function ($produit) {
            $dernierCout = $produit->historiqueCouts->sortByDesc('created_at')->first();
            $dernierPrix = $produit->historiquePrixVentes->sortByDesc('created_at')->first();

            return [
                'id' => $produit->id,
                'nom' => $produit->nom,
                'cout_total' => $dernierCout?->cout_total,
                'prix_vente' => $dernierPrix?->prix_vente,
                'rentable' => ($dernierCout && $dernierPrix)
                    ? $dernierPrix->prix_vente >= $dernierCout->cout_total
                    : null,
            ];
        });

        $nonRentables = $donnees->where('rentable', false)->count();

        $coutMoyen = $donnees->pluck('cout_total')->filter()->avg();
        $prixMoyen = $donnees->pluck('prix_vente')->filter()->avg();

        return response()->json([
            'nombre_produits' => $nbProduits,
            'produits_non_rentables' => $nonRentables,
            'cout_moyen' => round($coutMoyen ?? 0, 2),
            'prix_moyen' => round($prixMoyen ?? 0, 2),
            'produits' => $donnees,
        ]);
    }

    public function kpi()
    {
        $produits = Produit::with(['historiqueCouts', 'historiquePrixVentes'])->get();

        return $produits->map(function ($produit) {
            $dernierCout = $produit->historiqueCouts->sortByDesc('created_at')->first();
            $dernierPrix = $produit->historiquePrixVentes->sortByDesc('created_at')->first();

            return [
                'nom' => $produit->nom,
                'cout_total' => $dernierCout?->cout_total,
                'prix_vente' => $dernierPrix?->prix_vente,
            ];
        });
    }
}