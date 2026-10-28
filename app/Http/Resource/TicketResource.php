<?php

namespace App\Http\Resource;
use Illuminate\Http\Request;



class TicketResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'statut' => $this->statut,
             'priorite' => $this->priorite,
            'enregistrer' => $this->created_at?->format('d/m/Y'),
            'commentaires' => $this->whenLoaded('commentaires'),
        ];
    }
}
