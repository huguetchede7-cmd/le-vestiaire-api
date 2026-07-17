<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variante_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('taille_id')->nullable()->constrained('tailles');
            $table->string('couleur')->nullable();
            $table->string('sku')->unique()->nullable();
            $table->decimal('prix_supplement', 10, 2)->default(0);
            $table->integer('quantite_stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variante_produits');
    }
};
