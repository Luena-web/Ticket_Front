<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\TicketInterfaceService;
use App\Repositories\Interfaces\TicketRepositoryInterface;

class TicketImplementationService implements TicketInterfaceService
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository
    ) {}

    public function getAll()
    {
        
        return $this->ticketRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->ticketRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->ticketRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->ticketRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->ticketRepository->delete($id);
    }

    public function updatePriorite(int $id, string $priorite)
{
    return $this->ticketRepository->update($id, ['priorite' => $priorite]);
}

    public function updateStatut(int $id, string $statut)
{
    return $this->ticketRepository->update($id, ['statut' => $statut]);
}

}
