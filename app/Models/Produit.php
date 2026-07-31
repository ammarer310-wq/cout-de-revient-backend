<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
    'nom',
    'description',
    'grammage',
    'rendement',
    'temps_production'
];

public function recettes()
{
    return $this->hasMany(
        Recette::class
    );
}

public function pricings()
{
    return $this->hasMany(Pricing::class);
}

public function mainOeuvre()
{
    return $this->hasOne(MainOeuvre::class);
}

public function packagings()
{
    return $this->hasMany(Packaging::class);
}
public function historiqueCouts()
{
    return $this->hasMany(HistoriqueCout::class);
}

public function historiquePrixVentes()
{
    return $this->hasMany(HistoriquePrixVente::class);
}
}
