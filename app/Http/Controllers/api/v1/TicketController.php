<?php

namespace App\Http\Controllers\api\v1;
use App\DTOs\TicketDTO;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\createTicketresquest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\JsonResponse;

// IMPORT DES ATTRIBUTS OPENAPI NATIFS
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API REST de Gestion de Tickets Assistance",
    version: "1.0.0",
    description: "Documentation interactive de l'API d'assistance de notre fil rouge."
)]
#[OA\Server(
    url: "http://127.0.0",
    description: "Serveur API Local V1"
)]
class TicketController extends Controller
{
    #[OA\Get(
        path: "/tickets",
        summary: "Récupérer tous les tickets de support",
        description: "Retourne une liste complète de tous les tickets accompagnés de l'auteur",
        tags: ["Tickets"],
        responses: [
            new OA\Response(response: 200, description: "Liste des tickets récupérée avec succès"),
            new OA\Response(response: 500, description: "Erreur interne du serveur")
        ]
    )]
    public function index(): JsonResponse
    {
         $tickets = Ticket::with('utilisateur')->latest()->get();

        return response()->json([
          'success' => true,
            'data'    => $tickets
         ], 200);

        // $tikets = Ticket :: All();
        // return response()->json([
        // 'success'=> 'statut 200', 
        // 'data'=>$tickets
        // ]
        //);
    }

    /**
     * Créer un nouveau ticket.
     */
    public function store(createTicketresquest $request): JsonResponse
    {
        $ticket = Ticket::create(
            // Validation des données par le DTO
            $ticketDTO = TicketDTO::fromRequest($request),
            //  On insère en base de données en convertissant le DTO en tableau
        $ticket = Ticket::create($ticketDTO->toArray()),
        );
        return response()->json([
            'success' => 'statut 201',
            'message' => 'Ticket créé avec succès.',
            'data'    => $ticket->load('utilisateur')
        ], 201);
    }

    /**
     * Afficher un ticket spécifique.
     */
    public function show(string $id): JsonResponse
    {
        $ticket = Ticket::with(['utilisateur', 'commentaires.auteur'])->find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket introuvable.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $ticket
        ], 200);
    }

    /**
     * Mettre à jour un ticket.
     */
    public function update(UpdateTicketRequest $request, string $id): JsonResponse
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket introuvable.'
            ], 404);
        }

        $ticket->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Ticket mis à jour avec succès.',
            'data'    => $ticket
        ], 200);
    }

    /**
     * Supprimer un ticket.
     */
    public function destroy(string $id): JsonResponse
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket introuvable.'
            ], 404);
        }

        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket supprimé définitivement.'
        ], 200);
    }
}
