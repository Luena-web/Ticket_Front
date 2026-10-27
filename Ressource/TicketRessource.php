<?php

namespace App\Http\Resources;
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
            'enregistrer' => $this->created_at?->format('d/m/Y'),
        ];
    }
}
