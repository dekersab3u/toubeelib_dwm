<?php

namespace toubeelib\core\services\rdv;

use PHPUnit\Framework\Exception;
use Ramsey\Uuid\Uuid;
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
    private $horairesPraticien = [
        'Monday'    => ['08:00', '17:00'],
        'Tuesday'   => ['09:00', '18:00'],
        'Wednesday' => ['08:30', '16:00'],
        'Thursday'  => ['10:00', '19:00'],
        'Friday'    => ['08:00', '15:00'],
        'Saturday'  => ['09:00', '13:00'],  // Optionnel : Samedi matin uniquement
        'Sunday'    => [null, null],        // Fermé le dimanche
    ];



    private RdvRepositoryInterface $rdvRep;
    private PraticienRepositoryInterface $praRep;

    public function __construct(RdvRepositoryInterface $rdvRep, PraticienRepositoryInterface $p) {
        $this->rdvRep = $rdvRep;
        $this->praRep = $p;

    }

    public function consulterListeRDVs(): array
    {
        try {

            $rdvs = $this->rdvRep->getRdvs();


            return array_map(fn($rdv) => new rdvDTO($rdv), $rdvs);

        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la récupération des rendez-vous : " . $e->getMessage());
        }
    }

    public function consulterRDV(string $ID): rdvDTO
    {
        try {
            $rdv = $this->rdvRep->getRdvById($ID);
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

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $specialiteLabel, \DateTimeImmutable $dateRdv): rdvDTO
    {
        try {

            $prat = $this->praRep->getPraticienById($ID_Praticien);

            $praticienSpecialites = $this->praRep->getSpecialitesByPraticienId($ID_Praticien);

            $specialiteTrouvee = false;
            foreach ($praticienSpecialites as $specialite) {
                if ($specialite->toDTO()->label === $specialiteLabel) {
                    $specialiteTrouvee = true;
                    break;
                }
            }

            if (!$specialiteTrouvee) {
                throw new ServiceRdvInvalidDataException("La spécialité spécifiée ne correspond pas à celles du praticien.");
            }


            $dateDebut = new \DateTime($dateRdv->format('Y-m-d 00:00:00'));
            $dateFin = new \DateTime($dateRdv->format('Y-m-d 23:59:59'));
            $dispos = $this->listeDisponibilitesPraticien($ID_Praticien, $dateDebut, $dateFin);


            $rdvDispo = false;
            foreach ($dispos as $dispo) {
                if ($dispo->format('Y-m-d H:i') === $dateRdv->format('Y-m-d H:i')) {
                    $rdvDispo = true;
                    break;
                }
            }

            if (!$rdvDispo) {
                throw new ServiceRdvInvalidDataException("Le créneau du rendez-vous n'est pas disponible.");
            }

        } catch (ServicePraticienInvalidDataException $e) {
            throw new ServiceRdvInvalidDataException("Praticien non valide : " . $e->getMessage());
        }


        $rdv = new RendezVous($ID_Patient, $ID_Praticien, $dateRdv);


        $rdv->setID(Uuid::uuid4()->toString());


        $rdv->setSpecialite($specialiteLabel);


        return $rdv->toDTO();
    }


    public function annulerRDV(string $ID)
    {
        $rdv = $this->rdvRep->getRdvById($ID);
        $rdv->setStatus('Annule');
    }

    public function listeDisponibilitesPraticien(string $ID_Praticien, \DateTime $dateDebut, \DateTime $dateFin): array
    {
        $rdvs = $this->rdvRep->getRdvsByPraticienId($ID_Praticien);

        $dispos = [];

        while ($dateDebut <= $dateFin) {
            $jourSemaine = $dateDebut->format('l');
            $horaireJour = $this->horairesPraticien[$jourSemaine];

            if ($horaireJour[0] === null || $horaireJour[1] === null) {
                $dateDebut->modify('+1 day');
                continue;
            }

            $heureDebut = new \DateTime($dateDebut->format('Y-m-d') . ' ' . $horaireJour[0]);
            $heureFin = new \DateTime($dateDebut->format('Y-m-d') . ' ' . $horaireJour[1]);

            $creneau = clone $heureDebut;
            while ($creneau < $heureFin) {
                $dispo = true;
                foreach ($rdvs as $rdv) {

                    if ($rdv->dateRdv->getTimestamp() == $creneau->getTimestamp()) {
                        $dispo = false;
                        break;
                    }
                }

                if ($dispo) {
                    $dispos[] = clone $creneau;
                }
                $creneau->add(new \DateInterval('PT30M'));
            }

            $dateDebut->modify('+1 day');
        }

        return $dispos;
    }


  /*  public function modifierRdv(string $IDr, ?string $ID_Patient = null, ?string $specialite = null): rdvDTO
    {
        try {
            $rdv = $this->rdvRep->getRdvById($IDr);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRdvInvalidDataException("Rendez-vous non trouvé avec l'ID: $IDr");
        }
        if ($ID_Patient !== null) {
            $rdv->setIDPatient($ID_Patient);
        }
        if ($specialite !== null) {
            $prat = $this -> getPraticienRDV($rdv->ID_Praticien);

            if ($specialite !== $prat->specialite_label) {
                throw new ServiceRdvInvalidDataException("La spécialité spécifiée ne correspond pas au praticien indiqué");
            }
            $rdv->setSpecialite($specialite);
        }

        return $rdv->toDTO();
    }
*/

    public function marquerCommeHonore(string $IDr): void
    {
        $rdv = $this->rdvRep->getRdvById($IDr);
        if($rdv->status === 'prévu'){
            $rdv->setStatus('honoré');
        }
    }


    public function marquerCommeNonHonore(string $IDr): void
    {
        $rdv = $this->rdvRep->getRdvById($IDr);
        if($rdv->status === 'prévu'){
            $rdv->setStatus('non honoré');
        }
    }


    public function marquerCommePaye(string $IDr): void
    {
        $rdv = $this->rdvRep->getRdvById($IDr);
        if($rdv->status === 'honoré'){
            $rdv->setStatus('payé');
        }
    }


    public function marquerCommeTransmis(string $IDr): void
    {
        $rdv = $this->rdvRep->getRdvById($IDr);
        if($rdv->status === 'payé'){
            $rdv->setStatus('transmis');
        }
    }




}
