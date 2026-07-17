<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodePromo extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type_reduction', 'valeur', 'date_debut', 'date_fin', 'actif'];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
