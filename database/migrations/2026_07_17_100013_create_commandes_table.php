<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('adresse_id')->constrained('adresses');
            $table->foreignId('code_promo_id')->nullable()->constrained('code_promos');
            $table->decimal('montant_total', 10, 2);
            $table->enum('statut', ['en_attente', 'validee', 'en_preparation', 'expediee', 'livree', 'annulee'])
                  ->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
