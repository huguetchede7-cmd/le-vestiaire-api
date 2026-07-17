<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'adresse_id', 'code_promo_id', 'montant_total', 'statut'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adresse()
    {
        return $this->belongsTo(Adresse::class);
    }

    public function codePromo()
    {
        return $this->belongsTo(CodePromo::class);
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
