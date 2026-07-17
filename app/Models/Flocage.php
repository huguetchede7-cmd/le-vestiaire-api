<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flocage extends Model
{
    use HasFactory;

    protected $fillable = ['nom_joueur', 'numero', 'style_ecriture', 'couleur', 'prix_supplement'];

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
