<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriquePrix extends Model
{
    protected $table = 'historique_prix';

    protected $fillable = [
        'matierepremiere_id',
        'prix',
        'date_prix',
    ];

    public function matierePremiere()
    {
        return $this->belongsTo(MatierePremiere::class, 'matierepremiere_id');
    }
}