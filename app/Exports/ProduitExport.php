<?php

namespace App\Exports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProduitExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $produits = Produit::with(['historiqueCouts', 'historiquePrixVentes'])->get();

        return $produits->map(function ($produit) {
            $dernierCout = $produit->historiqueCouts->sortByDesc('created_at')->first();
            $dernierPrix = $produit->historiquePrixVentes->sortByDesc('created_at')->first();

            return [
                'nom' => $produit->nom,
                'cout_total' => $dernierCout?->cout_total ?? 0,
                'prix_vente' => $dernierPrix?->prix_vente ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Produit',
            'Cout',
            'Prix vente',
        ];
    }
}