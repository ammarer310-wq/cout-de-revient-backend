<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeIndirecte extends Model
{
    protected $fillable = [
        'nom',
        'montant',
        'periode',
        'methode_repartition', // volume_produit, temps_machine, quantite_produite
    ];

    public function produits()
    {
        return $this->belongsToMany(
            Produit::class,
            'charge_indirecte_produit'
        )->withPivot('cle_repartition');
    }
}