<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flocages', function (Blueprint $table) {
            $table->id();
            $table->string('nom_joueur')->nullable();
            $table->string('numero', 5)->nullable();
            $table->string('style_ecriture')->nullable();
            $table->string('couleur')->nullable();
            $table->decimal('prix_supplement', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flocages');
    }
};
