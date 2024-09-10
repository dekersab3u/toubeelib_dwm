<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\rdv\RendezVous;

interface RdvRepositoryInterface
{
    public function getRdvById(string $id) : RendezVous;

    public function getPraticienById(string $id) : Praticien;
}