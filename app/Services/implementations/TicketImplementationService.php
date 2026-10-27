<?php
 namespace App\Services\TicketImplementationService;
 use App\Models\Ticket;
 use App\Services\interfaces\TicketImplementationService;
 use App\Repositories\Interfaces\TicketRepositoryInterface;


 class TicketImplemnetationService implements TicketInterfaceService{

  public function __construct(
        private TickekRepositoryInterface $ticketkRepository//constructeur
    ) {}
    public function getAll ()
    {
        return this->ticketRepository->getAll();
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
        $ticket = $this->ticketRepository->findById($id);
        if ($ticket) {
            return $this->ticketRepository->delete($id);
        }
        return false; 
    }
    
    
    
 }



?>