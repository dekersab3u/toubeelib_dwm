<?php

namespace toubeelib\core\services\rdv;

use PHPUnit\Framework\Exception;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\InputPraticienDTO;
use toubeelib\core\dto\PraticienDTO;
use toubeelib\core\dto\rdvDTO;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;


class ServiceRDV implements RdvServiceInterface
{

    private RdvRepositoryInterface $rdvRep;
    private PraticienRepositoryInterface $praRep;

    public function __construct(RdvRepositoryInterface $rdvRep, PraticienRepositoryInterface $p) {
        $this->rdvRep = $rdvRep;
        $this->praRep = $p;

    }
    public function consulterRDV(string $ID): rdvDTO
    {
        try {
            $rdv = $this->rdvRep->getRdvById($ID);
            $this->getPraticienRDV($rdv->ID_Praticien);
            return new rdvDTO($rdv);
        } catch(ServiceRdvInvalidDataException $e) {
            throw new ServiceRdvInvalidDataException("Invalid RDV ID");
        }

    }

    public function getPraticienRDV(string $ID){
        try{
            $praticien = $this->praRep->getPraticienById($ID);
            return new PraticienDTO($praticien);
        }catch(ServiceRdvInvalidDataException $e){
            throw new ServiceRdvInvalidDataException("Invalid Praticien ID");
        }
    }

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $status, string $specialite, \DateTime $dateRdv): rdvDTO
    {
        $rdv = new RendezVous($ID_Patient, $ID_Praticien, $status, $dateRdv);
        return $rdv->toDTO();
    }

}