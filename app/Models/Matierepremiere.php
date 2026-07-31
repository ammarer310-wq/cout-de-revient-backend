<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fournisseur;


class Matierepremiere extends Model
{
    protected $fillable = [
        'nom',
        'prix_achat',
        'unite',
        'fournisseur_id',
    ];

    public function historiquesPrix()
    {
        return $this->hasMany(HistoriquePrix::class);
    }

    public function fournisseur()
{
    return $this->belongsTo(
        Fournisseur::class
    );
}

public function recettes()
{
    return $this->hasMany(
        Recette::class,
        'matierepremiere_id'
    );
}

}