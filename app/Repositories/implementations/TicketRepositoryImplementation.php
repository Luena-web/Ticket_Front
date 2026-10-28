<?php

namespace App\Repositories\Implementations;

use App\Models\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class TicketRepositoryImplementation implements TicketRepositoryInterface
{
   
    public function getAll()
    {
        return Ticket::with('utilisateur')->latest()->get();
    }

  
    public function findById(int $id)
    {
        return Ticket::with(['utilisateur', 'commentaires.auteur'])->find($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
 // Déclenchement automatique d'envoi de e-mail à tout le monde
    event(new TicketCreatedEvent($ticket));
    }

    public function update(int $id, array $data)
    {
        $ticket = Ticket::find($id);  
        if ($ticket) {
            $ticket->update($data);
            $ticket->refresh();
        }
        return $ticket;
    }

    public function delete(int $id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            return $ticket->delete();
        }
        return false; 
    }
}
