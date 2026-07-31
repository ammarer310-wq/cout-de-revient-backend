<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueCout extends Model
{
    protected $table = 'historique_couts';

    protected $fillable = [
        'produit_id',
        'cout_matieres',
        'cout_main_oeuvre',
        'cout_packaging',
        'charges_indirectes',
        'cout_total',
        'cout_unitaire',
        'quantite_produite',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}