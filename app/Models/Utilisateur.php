<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany; 
class Utilisateur extends Model

{
     use HasApiTokens;
   protected $table = 'utilisateurs';
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'role',
        'password'
    ];
// un user peut écrire créer un ou  plusieurs tickets
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'utilisateur_id');
    }
// un user peut écrire plusieurs commentaires
    public function commentaires(): HasMany {
    return $this->hasMany(Commentaire::class, 'utilisateur_id');
}
}

