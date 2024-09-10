<?php

namespace toubeelib\core\services\rdv;

use PHPUnit\Framework\Exception;
use toubeelib\core\dto\InputPraticienDTO;
use toubeelib\core\dto\rdvDTO;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
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
            $rdv = $this->rdvRep->getRdvById($ID);
            $this->getPraticienRDV($rdv->ID_Praticien);
            return new rdvDTO($rdv);
        } catch(ServiceRdvInvalidDataException $e) {
            throw new ServiceRdvInvalidDataException("Invalid RDV ID");
        }

    }

    public function getPraticienRDV(string $ID){
        try{
            $praticien = $this->rdvRep->getPraticienById($ID);
            return new InputPraticienDTO($praticien->nom, $praticien->prenom, $praticien->adresse, $praticien->tel, $praticien->specialite);
        }catch(ServiceRdvInvalidDataException $e){
            throw new ServiceRdvInvalidDataException("Invalid Praticien ID");
        }
    }
}