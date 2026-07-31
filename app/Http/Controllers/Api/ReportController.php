<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ProduitExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Produit;

class ReportController extends Controller
{
     public function exportExcel()
    {
        return Excel::download(

            new ProduitExport(),

            'rapport.xlsx'

        );
    }

    public function exportPdf()
{
    $produits = Produit::with(['historiqueCouts', 'historiquePrixVentes'])->get();

    $donnees = $produits->map(function ($produit) {
        $dernierCout = $produit->historiqueCouts->sortByDesc('created_at')->first();
        $dernierPrix = $produit->historiquePrixVentes->sortByDesc('created_at')->first();

        return [
            'nom' => $produit->nom,
            'cout_total' => $dernierCout?->cout_total,
            'prix_vente' => $dernierPrix?->prix_vente,
            'rentable' => ($dernierCout && $dernierPrix)
                ? $dernierPrix->prix_vente >= $dernierCout->cout_total
                : null,
        ];
    });

    $pdf = Pdf::loadView('rapport-pdf', ['produits' => $donnees]);

    return $pdf->download('rapport.pdf');
}
}
