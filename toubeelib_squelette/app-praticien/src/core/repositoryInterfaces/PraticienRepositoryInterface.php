<?php

namespace praticien\core\repositoryInterfaces;

use praticien\core\domain\entities\praticien\Praticien;
use praticien\core\domain\entities\praticien\Specialite;

interface PraticienRepositoryInterface
{

    public function getSpecialitesByPraticienId(string $id): array;
    public function save(Praticien $praticien): string;
    public function getPraticienById(string $id): Praticien;

    public function getPraticiens(): array;

}