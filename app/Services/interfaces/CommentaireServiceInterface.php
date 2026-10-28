<?php

namespace App\Services\Interfaces;

use App\Models\Commentaire;

interface CommentaireServiceInterface
{
    public function addCommentToTicket(int $ticketId, array $data): Commentaire;
}
