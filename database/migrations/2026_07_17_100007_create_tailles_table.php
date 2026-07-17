<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tailles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 20);
            $table->string('type_taille', 20)->default('vetement');
            $table->integer('ordre')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailles');
    }
};
