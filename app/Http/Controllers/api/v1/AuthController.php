<?php
namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Auth', description: 'Gestion des tickets de l\'API')]

class AuthController extends Controller
{
    #[OA\Post(
        path: "/login",
        summary: "Créer un nouveau ticket d'assistance",
        description: "Enregistre un ticket de support en base de données et l'associe à un collaborateur.",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email"],
                properties: [
                    new OA\Property(property: "email", type: "email", example: "keli@gmail.com")
                    
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Ticket créé avec succès"),
            new OA\Response(response: 422, description: "Données de validation incorrectes")
        ]
    )]
    
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:utilisateurs,email',
        ]);

        // On récupère l'utilisateur par son email
        $user = Utilisateur::where('email', $request->email)->first();

        // On génère un jeton d'accès sécurisé pour cet utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'      => true,
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ], 200);
    }

    /**
     * Déconnexion.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie.'
        ], 200);
    }
public function register(Request $request): JsonResponse
{
    try {
        $validated = $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:utilisateurs,email',
            'role'   => 'required|string|in:agent,utilisateur',
        ]);

        $user = Utilisateur::create([
            'nom'    => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email'  => $validated['email'],
            'role'   => $validated['role'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success'      => true,
            'access_token' => $token,
            'user'         => $user
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error'   => $e->getMessage(),
            'trace'   => $e->getTraceAsString()
        ], 500);
    }
}


}
