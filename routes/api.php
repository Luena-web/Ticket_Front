<?php

use Illuminate\Http\Request;
 use App\Http\Controllers\api\v1\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/tickets', [TicketController::class, 'index']);
Route::get('/v1/tickets/{id}', [TicketController::class, 'show']);
Route::post('/v1/tickets', [TicketController::class, 'store']);
Route::put('/v1/tickets', [TicketController::class, 'update']);
Route::patch('/v1/tickets/{id}/priorite', [TicketController::class, 'priorite']);
Route::patch('/v1/tickets/{id}/statut', [TicketController::class, 'statut']);



