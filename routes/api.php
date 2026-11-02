<?php

use Illuminate\Http\Request;
use App\Http\Controllers\api\v1\TicketController;
use App\Http\Controllers\api\v1\CommentaireController;
use App\Http\Controllers\api\v1\AuthController; 


use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {
//Route::post('/login', [AuthController::class, 'login']);
//Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/v1/tickets', [TicketController::class, 'index']);
Route::get('/v1/tickets/{id}', [TicketController::class, 'show']);
Route::post('/v1/tickets', [TicketController::class, 'store'])->middleware('auth:sanctum');
// Route::post('v1/commentaires', [CommentaireController::class, 'store']);
Route::post(
    'v1/tickets/{ticketId}/commentaires', [CommentaireController::class, 'store']);
Route::get(
    '/v1/tickets/{ticketId}/commentaires', [CommentaireController::class, 'index']);
Route::put('/v1/tickets/{id}', [TicketController::class, 'update']);
Route::patch('/v1/tickets/{id}/priorite', [TicketController::class, 'priorite']);
Route::patch('/v1/tickets/{id}/statut', [TicketController::class, 'statut']);
Route::delete('/v1/tickets/{id}', [TicketController::class, 'destroy']);
// });

Route::prefix('v1')->group(function () {
    
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
   
});

