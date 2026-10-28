<?php

namespace App\Listeners;

use App\Events\TicketCreatedEvent;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Mail;

class SendTicketNotificationListener
{
    public function handle(TicketCreatedEvent $event): void
    {
        $ticket = $event->ticket;
        
        //  récupération du email de TOUS les utilisateurs du système
        $emails = Utilisateur::pluck('email')->toArray();

        //  envoie d'un e-mail groupé à tous les utilisateurs
        Mail::raw("Un nouveau ticket d'assistance a été créé par un collaborateur.\n\nTitre : {$ticket->titre}\nDescription : {$ticket->description}", function ($message) use ($emails, $ticket) {
            $message->to($emails)
                    ->subject(" Nouveau ticket : " . $ticket->titre);
        });
    }
}
