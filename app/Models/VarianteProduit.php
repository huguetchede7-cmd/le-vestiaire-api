<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianteProduit extends Model
{
    use HasFactory;

    protected $fillable = ['produit_id', 'taille_id', 'couleur', 'sku', 'prix_supplement', 'quantite_stock'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function taille()
    {
        return $this->belongsTo(Taille::class);
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
