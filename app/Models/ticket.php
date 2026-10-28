<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ticket extends Model
{
  protected $fillable =[
     'titre',
    'description',
    'status',
    'priority',
    'utilisateur_id',
    'statut',
    'priorite'

   
  ];

   // Récupère l'utilisateur qui a créé ce ticket 
   // 1 ticket est crée par un seul utilisateur (relation :BelongsTo)
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
        
    }

    // un seul ticket a plusieurs commentaires

    public function commentaires(): HasMany {
    return $this->hasMany(Commentaire::class, 'ticket_id');
}
}

