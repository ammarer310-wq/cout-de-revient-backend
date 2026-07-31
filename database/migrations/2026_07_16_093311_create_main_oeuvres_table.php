<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_oeuvres', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->decimal('cout_horaire', 10, 2)->nullable();
            $table->decimal('temps_minutes', 10, 2)->nullable();
            $table->foreignId('produit_id')->nullable()->constrained('produits')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('main_oeuvres');
    }
};