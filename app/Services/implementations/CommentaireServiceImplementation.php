<?php

namespace App\Services\Implementations;

use App\Models\Commentaire;
use App\Models\Ticket; 
use App\Models\Utilisateur;
use App\Services\Interfaces\CommentaireServiceInterface;
use App\Repositories\Interfaces\CommentaireRepositoryInterface;

class CommentaireServiceImplementation implements CommentaireServiceInterface
{
    public function __construct(
        private CommentaireRepositoryInterface $commentaireRepository
    ) {}

    public function addCommentToTicket(int $ticketId, array $data): Commentaire
    {
        $data['ticket_id'] = $ticketId;

        //  Enregistrement  du commentaire en base de données
        $commentaire = $this->commentaireRepository->create($data);

        //  Vérification de l'auteur du commentaire
        $auteur = Utilisateur::find($data['utilisateur_id']);

        if ($auteur && in_array($auteur->role, ['agent'])) {
            // Si c'est un agent  qui écrit, on récupère le ticket concerné
            $ticket = Ticket::find($ticketId);
            if ($ticket) {
                // On met à jour son statut à "resolu" automatiquement
                $ticket->update(['status' => 'resolu']);
            }
        }

        return $commentaire;
    }
}
