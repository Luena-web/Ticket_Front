<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;


#[OA\Info(
    version: "1.0.0",
    description: "Documentation interactive de l'API d'assistance de notre fil rouge",
    title: "API REST de Gestion de Tickets Assistance"
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Serveur Local'
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    name: "Authorization",
    in: "header",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
abstract class Controller
{
    // ...
}
