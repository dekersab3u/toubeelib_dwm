<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\rdvDTO;

interface RdvServiceInterface
{
    public function consulterRDV(string $ID) : rdvDTO;

    public function creerRDV(string $ID_Patient, string $ID_Praticien, string $status, string $specialite, \DateTime $dateRdv) : rdvDTO;

    public function annulerRDV(string $ID);

}