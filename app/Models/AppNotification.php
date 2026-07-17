<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppNotification extends Model
{
    use HasFactory;

    protected $table = 'app_notifications';

    protected $fillable = ['user_id', 'titre', 'message', 'lue'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
