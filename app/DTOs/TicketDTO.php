<?php

namespace App\DTOs;

use App\Http\Requests\createTicketresquest;

class TicketDTO
{
    // L'utilisation de readonly empêche la modification des données après création
    public function __construct(
        public readonly string $titre,
        public readonly string $description,
        public readonly int $utilisateur_id, 
        public readonly string $priorite = 'moyenne' 
    ) {}

    /**
     * Instanciation automatique du DTO à partir de votre Form Request validée.
     */
    public static function fromRequest(createTicketresquest $request): self
    {
        return new self(
            titre: $request->validated('titre'),
            description: $request->validated('description'),
            utilisateur_id: auth()->id() ?? 1, 
            priorite: $request->validated('priorite', 'moyenne'),
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
            'utilisateur_id' => $this->utilisateur_id, 
            'priorite'       => $this->priorite,
        ];
    }
}
