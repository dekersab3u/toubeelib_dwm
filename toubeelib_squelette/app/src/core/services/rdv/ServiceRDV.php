<?php

namespace toubeelib\core\services\rdv;

use PHPUnit\Framework\Exception;
use toubeelib\core\dto\rdvDTO;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;

class ServiceRDV implements RdvServiceInterface
{

    private RdvRepositoryInterface $rdvRep;

    public function __construct(RdvRepositoryInterface $rdvRep) {
        $this->rdvRep = $rdvRep;
    }
    public function consulterRDV(string $ID): rdvDTO
    {
        try {
            $rdv = this->rdvRep->getRDV($ID);
            return new rdvDTO($rdv);
        } catch $e Exception::

        return
    }
}