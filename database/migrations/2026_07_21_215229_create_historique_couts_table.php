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
      Schema::create('historique_couts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
        $table->decimal('cout_matieres', 10, 4);
        $table->decimal('cout_main_oeuvre', 10, 4);
        $table->decimal('cout_packaging', 10, 4);
        $table->decimal('charges_indirectes', 10, 4);
        $table->decimal('cout_total', 10, 4);
        $table->decimal('cout_unitaire', 10, 4);
        $table->float('quantite_produite');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_couts');
    }
};
