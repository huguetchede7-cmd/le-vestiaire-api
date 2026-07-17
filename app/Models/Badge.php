<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'image', 'prix'];

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
