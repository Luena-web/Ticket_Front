<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model

{
   protected $table = 'utilisateurs';
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'role'
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

