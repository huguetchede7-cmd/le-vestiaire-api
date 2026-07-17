<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['type_produit_id', 'nom', 'marque', 'description', 'prix_base', 'actif'];

    public function typeProduit()
    {
        return $this->belongsTo(TypeProduit::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'produit_categorie');
    }

    public function images()
    {
        return $this->hasMany(ProduitImage::class)->orderBy('ordre');
    }

    public function variantes()
    {
        return $this->hasMany(VarianteProduit::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }
}
