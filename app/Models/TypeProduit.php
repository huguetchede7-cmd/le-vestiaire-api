<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'gere_taille', 'gere_couleur', 'gere_personnalisation'];

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
