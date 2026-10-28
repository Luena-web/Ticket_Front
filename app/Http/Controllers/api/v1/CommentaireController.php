<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CommentaireServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentaireController extends Controller
{
    // Injection du service via le constructeur
    public function __construct(
        private CommentaireServiceInterface $commentaireService
    ) {}

    public function store(Request $request, int $ticketId): JsonResponse
    {
        $request->validate([
            'utilisateur_id' => 'required|integer|exists:utilisateurs,id',
            'contenu'        => 'required|string',
        ]);

        // Appel de la couche Service
        $commentaire = $this->commentaireService->addCommentToTicket($ticketId, $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Commentaire ajouté avec succès.',
            'data'    => $commentaire->load('auteur')
        ], 201);
    }
}
