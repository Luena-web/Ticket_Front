<?php

namespace App\DTOs;

use App\Http\Requests\createTicketresquest;

class TicketDTO
{
    public function __construct(
        public readonly string $titre,
        public readonly string $description,
        public readonly string $priorite,
        public readonly int $utilisateur_id,
        public readonly string $statut = 'non resolu' 
    ) {}

    /**
     */
    public static function fromRequest(createTicketresquest $request): self
    {
        return new self(
            titre: $request->validated('titre'),
            description: $request->validated('description'),
            priorite: $request->validated('priorite'), 
            utilisateur_id: (int) ($request->user()?->id ?? auth()->id() ?? 1), 
            statut: $request->input('statut', 'non resolu') 
        );
    }

    /**
     * Conversion du DTO en tableau simple pour l'insertion de masse avec Eloquent (Ticket::create).
     */
    public function toArray(): array
    {
        return [
            'titre'          => $this->titre,
            'description'    => $this->description,
            'priorite'       => $this->priorite,
            'utilisateur_id' => $this->utilisateur_id, 
            'statut'         => $this->statut,
        ];
    }
}
