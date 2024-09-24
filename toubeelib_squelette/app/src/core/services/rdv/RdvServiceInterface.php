<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\rdvDTO;

interface RdvServiceInterface
{
    public function consulterRDV(string $ID) : rdvDTO;

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $status, string $specialite, \DateTimeImmutable $dateRdv) : rdvDTO;

    public function annulerRDV(string $ID);

    public function modifierRDV(string $IDr, string $ID_Patient, string $specialite);

    public function marquerCommeHonore(string $IDr);

    public function marquerCommeNonHonore(string $IDr);

    public function marquerCommePaye(string $IDr);

    public function marquerCommeTransmis(string $IDr);

}