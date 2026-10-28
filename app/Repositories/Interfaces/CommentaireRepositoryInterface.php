<?php

namespace App\Repositories\Interfaces;

use App\Models\Commentaire;

interface CommentaireRepositoryInterface
{
    public function create(array $data): Commentaire;
}
