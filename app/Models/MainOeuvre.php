<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainOeuvre extends Model
{
    protected $fillable = [
        'produit_id',
        'nom',
        'cout_horaire',
        'temps_minutes',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}