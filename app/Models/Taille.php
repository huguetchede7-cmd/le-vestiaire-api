<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taille extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['libelle', 'type_taille', 'ordre'];

    public function variantes()
    {
        return $this->hasMany(VarianteProduit::class);
    }
}
