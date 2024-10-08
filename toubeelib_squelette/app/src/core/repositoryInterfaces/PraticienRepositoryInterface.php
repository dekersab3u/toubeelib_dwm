<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialitesByPraticienId(string $id): array;
    public function save(Praticien $praticien): string;
    public function getPraticienById(string $id): Praticien;

}