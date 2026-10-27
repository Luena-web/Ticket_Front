<?php

namespace App\Repositories\Implementations;

use App\Models\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class TicketRepositoryImplementation implements TicketRepositoryInterface
{
    public function getAll()
    {
        return Ticket::all();
    }

    public function findById(int $id)
    {
        return Ticket::find($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update(int $id, array $data)
    {
        $ticket = $this->findById($id);
        if ($ticket) {
            $ticket->update($data);
        }
        return $ticket;
    }

    public function delete(int $id)
    {
        $ticket = $this->findById($id);
        if ($ticket) {
            return $ticket->delete();
        }
        return false; 
    }
   
}