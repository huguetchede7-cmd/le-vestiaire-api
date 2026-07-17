<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitImage extends Model
{
    use HasFactory;

    protected $fillable = ['produit_id', 'url', 'ordre'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
