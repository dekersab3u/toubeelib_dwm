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

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $status, string $specialite, \DateTime $dateRdv): rdvDTO
    {
        // Vérification de l'existence du praticien et de sa spécialité
        try {
            $prat = $this->praticienService->getPraticienById($ID_Praticien); // Appel de la méthode qui peut lever une exception

            // Vérification de la spécialité
            if ($specialite !== $prat->specialite) {
                throw new ServiceRdvInvalidDataException("La spécialité spécifiée ne correspond pas au praticien indiqué");
            }

        } catch (ServicePraticienInvalidDataException $e) {
            // Gestion de l'exception si le praticien n'existe pas
            throw new ServiceRdvInvalidDataException("Praticien non valide : " . $e->getMessage());
        }

        // Création du rendez-vous après validation des données
        $rdv = new RendezVous($ID_Patient, $ID_Praticien, $status, $dateRdv);
        return $rdv->toDTO();
    }

    public function annulerRDV(string $ID)
    {
        $rdv = $this->rdvRep->getRdvById($ID);
        $rdv->setStatus('Annule');
    }


}