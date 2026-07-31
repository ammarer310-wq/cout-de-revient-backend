<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $fillable = [

        'produit_id',
        'matierepremiere_id',
        'quantite_theorique',
        'perte_pourcentage',
        'rendement',
        'quantite_reelle'
    ];

    public function produit()
    {
        return $this->belongsTo(
            Produit::class
        );
    }

    public function matierePremiere()
{
    return $this->belongsTo(
        MatierePremiere::class,
        'matierepremiere_id'
    );
}
}
