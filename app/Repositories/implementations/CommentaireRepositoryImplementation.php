<?php

namespace App\Repositories\Implementations;

use App\Models\Commentaire;
use App\Repositories\Interfaces\CommentaireRepositoryInterface;

class CommentaireRepositoryImplementation implements CommentaireRepositoryInterface
{
    public function create(array $data): Commentaire
    {
        return Commentaire::create($data);
    }
}
