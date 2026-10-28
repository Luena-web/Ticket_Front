<?php

namespace App\Http\Controllers\api\v1;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Services\Interfaces\TicketInterfaceService;
use App\Http\Requests\createTicketresquest;
use App\Http\Requests\UpdateTicketRequest;
use App\DTOs\TicketDTO;
use Illuminate\Http\JsonResponse;
use App\Htpp\Resource\TicketResource;
use OpenApi\Attributes as OA;


#[OA\Tag(name: 'Tickets', description: 'Gestion des tickets de l\'API')]

class TicketController extends Controller
{
    public function __construct(
        private TicketInterfaceService $ticketService
    ) {}

    #[OA\Get(
        path: "/tickets",
        summary: "Récupérer tous les tickets de support",
        description: "Retourne la liste complète de tous les tickets accompagnés de leurs auteurs respectifs.",
        tags: ["Tickets"],
        responses: [
            new OA\Response(response: 200, description: "Liste des tickets récupérée avec succès"),
            new OA\Response(response: 500, description: "Erreur interne du serveur")
        ]
    )]
    public function index(): JsonResponse
    {
        $tickets = $this->ticketService->getAll();

        return response()->json([
            'success' => true,
           'data'    => $tickets
           //utilisation de Resource pour formater les datas à envoyer à user
             // 'data'=>  TicketResource::collection($tickets)
        ], 200);
    }

    #[OA\Post(
        path: "/tickets",
        summary: "Créer un nouveau ticket d'assistance",
        description: "Enregistre un ticket de support en base de données et l'associe à un collaborateur.",
        tags: ["Tickets"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["titre", "description", "utilisateur_id"],
                properties: [
                    new OA\Property(property: "titre", type: "string", example: "Problème réseau au 1er étage"),
                    new OA\Property(property: "description", type: "string", example: "Impossible de se connecter au Wi-Fi de l'entreprise depuis ce matin."),
                    new OA\Property(property: "priorite", type: "string", enum: ["faible", "moyenne", "elevee"], example: "elevee"),
                    new OA\Property(property: "utilisateur_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Ticket créé avec succès"),
            new OA\Response(response: 422, description: "Données de validation incorrectes")
        ]
    )]
    public function store(createTicketresquest $request): JsonResponse
    {
        // Transformation des données de Formrequest  en DTO
        $ticketDTO = TicketDTO::fromRequest($request);

        // Appel de la couche Service pour exécuter la logique de création
        $ticket = $this->ticketService->create($ticketDTO->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Ticket créé avec succès.',
            'data'    => $ticket->load('utilisateur')
        ], 201);
    }

    #[OA\Get(
        path: "/tickets/{id}",
        summary: "Afficher le détail d'un ticket",
        description: "Retourne les détails d'un ticket spécifique avec l'historique complet de ses commentaires.",
        tags: ["Tickets"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID du ticket", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Détails du ticket récupérés avec succès"),
            new OA\Response(response: 404, description: "Ticket introuvable")
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $ticket = $this->ticketService->findById($id);

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

    #[OA\Put(
        path: "/tickets/{id}",
        summary: "Mettre à jour un ticket",
        description: "Permet de modifier les données d'un ticket (titre, description, priorité ou statut).",
        tags: ["Tickets"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID du ticket", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Ticket mis à jour avec succès"),
            new OA\Response(response: 404, description: "Ticket introuvable")
        ]
    )]
    public function update(UpdateTicketRequest $request, int $id): JsonResponse
    {
        $updated = $this->ticketService->update($id, $request->validated());

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket introuvable ou mise à jour impossible.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ticket mis à jour avec succès.',
            'data'    => $this->ticketService->findById($id)
        ], 200);
    }

    #[OA\Delete(
        path: "/tickets/{id}",
        summary: "Supprimer un ticket définitivement",
        description: "Supprime un ticket d'assistance de la base de données (Action d'administration).",
        tags: ["Tickets"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID du ticket", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Ticket supprimé avec succès"),
            new OA\Response(response: 404, description: "Ticket introuvable")
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->ticketService->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket introuvable.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ticket supprimé définitivement.'
        ], 200);
    }


    public function priorite(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'priorite' => ['required', Rule::in(['faible', 'moyenne', 'elevee'])]
        ]);

        $ticket = $this->ticketService->updatePriorite($id, $validated['priorite']);

        if (!$ticket) {
            return response()->json(
                ['success' => false, 'message' => 'Ticket introuvable.']
                , 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Priorité mise à jour avec succès.',
            'data'    => $ticket
        ], 200);
    }

    public function statut(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'statut' => ['required', Rule::in(['non resolu', 'en cours', 'resolu'])]
        ]);

        $ticket = $this->ticketService->updateStatut($id, $validated['statut']);

        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket introuvable.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès.',
            'data'    => $ticket
        ], 200);
    }

}
