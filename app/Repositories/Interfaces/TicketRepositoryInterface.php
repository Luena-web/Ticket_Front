<?php 
namespace App\Repositories\Interfaces;
use App\Models\Ticket;

interface TicketRepositoryInterface{

    public function getAll();

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}


