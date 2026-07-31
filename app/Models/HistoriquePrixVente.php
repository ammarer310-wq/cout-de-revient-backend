<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriquePrixVente extends Model
{
    protected $table = 'historique_prix_ventes';

    protected $fillable = [
        'produit_id',
        'prix_vente',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
