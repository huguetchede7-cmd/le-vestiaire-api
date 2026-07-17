<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emballage extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'message_personnalise', 'prix'];

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
