<?php

namespace rdv\core\services\rdv;

use rdv\core\dto\rdvDTO;

interface RdvServiceInterface
{
    public function consulterListeRDVS() : array;
    public function consulterRDV(string $ID) : rdvDTO;

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $specialite, \DateTimeImmutable $dateRdv) : rdvDTO;

    public function annulerRDV(string $ID);

   // public function modifierRDV(string $IDr, string $ID_Patient, string $specialite);

    public function listeDisponibilitesPraticien(string $ID_Praticien, \DateTime $dateDebut, \DateTime $dateFin): array;

    public function marquerCommeHonore(string $IDr);

    public function marquerCommeNonHonore(string $IDr);

    public function marquerCommePaye(string $IDr);

    public function marquerCommeTransmis(string $IDr);

}