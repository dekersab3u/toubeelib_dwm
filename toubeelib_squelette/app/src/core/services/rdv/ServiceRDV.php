<?php

namespace toubeelib\core\services\rdv;

use PHPUnit\Framework\Exception;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\InputPraticienDTO;
use toubeelib\core\dto\PraticienDTO;
use toubeelib\core\dto\rdvDTO;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\praticien\ServicePraticienInvalidDataException;


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

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $status, string $specialite, \DateTimeImmutable $dateRdv): rdvDTO
    {
        try {
            $prat = null;
            $prat -> ServicePraticien->getPraticienById($ID_Praticien); // Appel de la méthode qui peut lever une exception

            if ($specialite !== $prat->specialite) {
                throw new ServiceRdvInvalidDataException("La spécialité spécifiée ne correspond pas au praticien indiqué");
            }

        } catch (ServicePraticienInvalidDataException $e) {
            throw new ServiceRdvInvalidDataException("Praticien non valide : " . $e->getMessage());
        }

        $rdv = new RendezVous($ID_Patient, $ID_Praticien, $status, $dateRdv);
        return $rdv->toDTO();
    }

    public function annulerRDV(string $ID)
    {
        $rdv = $this->rdvRep->getRdvById($ID);
        $rdv->setStatus('Annule');
    }

    public function modifierRdv(string $IDr, ?string $ID_Patient = null, ?string $specialite = null): rdvDTO
    {
        $rdv = $this->rdvRep->getRdvById($IDr);
        if ($ID_Patient !== null) {
            $rdv->setIDPatient($ID_Patient);
        }
        if ($specialite !== null) {
            $prat = null;
            $prat = $this -> getPraticienRDV($rdv->getID());

            // Vérification que la spécialité demandée fait bien partie des spécialités du praticien
            if ($specialite !== $prat->specialite) {
                throw new ServiceRdvInvalidDataException("La spécialité spécifiée ne correspond pas au praticien indiqué");
            }
            $rdv->setSpecialite($specialite);
        }

        return $rdv->toDTO();
    }


}