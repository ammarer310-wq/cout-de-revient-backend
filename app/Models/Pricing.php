<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = [
        'produit_id',
        'prix_vente',
        'marge_brute',
        'taux_marge',
        'prix_min_conseille'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
