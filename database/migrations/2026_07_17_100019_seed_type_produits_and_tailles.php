<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('type_produits')->insert([
            'nom' => 'Maillot',
            'gere_taille' => true,
            'gere_couleur' => true,
            'gere_personnalisation' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tailles = [
            ['libelle' => '6-8 ans', 'type_taille' => 'enfant', 'ordre' => 1],
            ['libelle' => '8-10 ans', 'type_taille' => 'enfant', 'ordre' => 2],
            ['libelle' => '10-12 ans', 'type_taille' => 'enfant', 'ordre' => 3],
            ['libelle' => '12-14 ans', 'type_taille' => 'enfant', 'ordre' => 4],
            ['libelle' => 'S', 'type_taille' => 'adulte', 'ordre' => 5],
            ['libelle' => 'M', 'type_taille' => 'adulte', 'ordre' => 6],
            ['libelle' => 'L', 'type_taille' => 'adulte', 'ordre' => 7],
            ['libelle' => 'XL', 'type_taille' => 'adulte', 'ordre' => 8],
            ['libelle' => 'XXL', 'type_taille' => 'adulte', 'ordre' => 9],
        ];

        DB::table('tailles')->insert($tailles);
    }

    public function down(): void
    {
        DB::table('tailles')->truncate();
        DB::table('type_produits')->where('nom', 'Maillot')->delete();
    }
};
