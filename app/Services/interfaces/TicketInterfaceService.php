<?php

namespace App\Services\Interfaces;

interface TicketInterfaceService
{
    public function getAll();

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function updatePriorite(int $id, string $priorite);
    
    public function updateStatut(int $id, string $statut);

}
