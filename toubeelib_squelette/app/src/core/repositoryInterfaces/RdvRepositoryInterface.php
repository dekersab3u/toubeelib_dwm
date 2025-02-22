<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\rdv\RendezVous;

interface RdvRepositoryInterface
{
    public function getRdvs() : array;
    public function getRdvById(string $id) : RendezVous;

    public function getPraticienById(string $id) : Praticien;

    public function getRdvsByPraticienId(string $id) : array;
}