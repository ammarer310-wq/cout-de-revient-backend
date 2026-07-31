<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('recettes', function (Blueprint $table) {

    $table->id();

    $table->foreignId('produit_id')
          ->constrained('produits')
          ->cascadeOnDelete();

    $table->foreignId('matierepremiere_id')
          ->constrained('matierepremieres')
          ->cascadeOnDelete();

    $table->decimal('quantite_theorique',10,2);

    $table->decimal('perte_pourcentage',5,2)
          ->default(0);

    $table->decimal('rendement',5,2)
          ->default(100);

    $table->decimal('quantite_reelle',10,2)
          ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
