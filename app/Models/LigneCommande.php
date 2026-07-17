<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id', 'variante_produit_id', 'flocage_id',
        'badge_id', 'emballage_id', 'quantite', 'prix_unitaire',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function varianteProduit()
    {
        return $this->belongsTo(VarianteProduit::class);
    }

    public function flocage()
    {
        return $this->belongsTo(Flocage::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function emballage()
    {
        return $this->belongsTo(Emballage::class);
    }
}
