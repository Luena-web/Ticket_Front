<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class commentaire extends Model
{
    protected $fillable =[
        'message',
        'ticket_id',
        'utilisateur_id',
        
    ];


public function ticket(): BelongsTo {
    return $this->belongsTo(Ticket::class, 'ticket_id');
}
public function auteur(): BelongsTo {
    return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
}
}