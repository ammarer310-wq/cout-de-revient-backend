<?php

namespace App\Services;

use App\Models\ChargeIndirecte;
use App\Models\Produit;

class CostEngine
{
    /**
     * Calcule le detail du cout a partir de parametres deja fournis
     * (utile pour la simulation, ou un calcul manuel sans recharger le produit).
     */
    public function calculerParams(
        $recettes,
        $coutMOD,
        $coutPackaging,
        $chargesIndirectes,
        $quantiteLot
    ) {
        $coutMatieres = 0;

        foreach ($recettes as $recette) {
            $prix = $recette['prix_achat'] ?? $recette->prix_achat;
            $quantite = $recette['quantite_reelle'] ?? $recette->quantite_reelle;
            $coutMatieres += $prix * $quantite;
        }

        $coutTotal = $coutMatieres + $coutMOD + $coutPackaging + $chargesIndirectes;
        $coutUnitaire = $coutTotal / $quantiteLot;

        return [
            'cout_matieres' => round($coutMatieres, 2),
            'cout_total' => round($coutTotal, 2),
            'cout_unitaire' => round($coutUnitaire, 2),
        ];
    }

    /**
     * Calcule le cout de revient complet d'un produit a partir de son id.
     *
     * @param  int  $produitId
     * @param  float  $quantiteProduite  Quantite du lot utilisee pour repartir
     *                                    la main d'oeuvre et les charges indirectes.
     *                                    A defaut, on suppose un lot de 1000 unites.
     */
    public function calculer($produitId, float $quantiteProduite = 1000)
    {
        $produit = Produit::with([
            'recettes.matierePremiere',
            'mainOeuvre',
            'packagings',
        ])->findOrFail($produitId);

        // --- Cout matieres premieres (deja au niveau unitaire, via quantite_reelle) ---
        $coutMatieres = 0;

        foreach ($produit->recettes as $recette) {
            $prix = $recette->matierePremiere->prix_achat;
            $quantite = $recette->quantite_reelle;

            $coutMatieres += $prix * $quantite;
        }

        // --- Cout main d'oeuvre (reparti sur la quantite du lot) ---
        $coutMOD = 0;

        if ($produit->mainOeuvre) {
            $coutTotalMOD = ($produit->mainOeuvre->temps_minutes / 60)
                * $produit->mainOeuvre->cout_horaire;

            $coutMOD = $coutTotalMOD / $quantiteProduite;
        }

        // --- Cout packaging (deja au niveau unitaire, on additionne chaque element) ---
        $coutPackaging = $produit->packagings->sum('prix');

        // --- Charges indirectes reparties ---
        $charges = $this->calculChargesIndirectes($produit, $quantiteProduite);

        // --- Total ---
        $coutTotal = $coutMatieres + $coutMOD + $coutPackaging + $charges;

        return [
            'cout_matieres' => round($coutMatieres, 4),
            'cout_main_oeuvre' => round($coutMOD, 4),
            'cout_packaging' => round($coutPackaging, 4),
            'chargesindirectes' => round($charges, 4),
            'cout_total' => round($coutTotal, 4),
            'cout_unitaire' => round($coutTotal, 4), // deja au niveau unitaire ici
            'quantite_produite_utilisee' => $quantiteProduite,
        ];
    }

    /**
     * Repartit les charges indirectes sur un produit selon leur methode,
     * et retourne le montant deja ramene au niveau unitaire.
     */
    private function calculChargesIndirectes($produit, float $quantiteProduite)
    {
        $total = 0;

        $charges = ChargeIndirecte::all();

        foreach ($charges as $charge) {
            switch ($charge->methode_repartition) {
                case 'quantite':
                    // montant total de la charge reparti sur la quantite du lot
                    $total += $charge->montant / $quantiteProduite;
                    break;

                case 'temps':
                    // charge proportionnelle au temps de production du produit
                    $coutParMinute = $charge->montant / 100; // base de reference, a ajuster selon ton contexte reel
                    $total += ($coutParMinute * $produit->temps_production) / $quantiteProduite;
                    break;

                case 'volume':
                    // charge proportionnelle au grammage/volume du produit
                    $total += $charge->montant * ($produit->grammage / 1000) / $quantiteProduite;
                    break;
            }
        }

        return $total;
    }
}