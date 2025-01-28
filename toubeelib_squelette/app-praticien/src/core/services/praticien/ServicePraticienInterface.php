<?php

namespace praticien\core\services\praticien;

use praticien\core\dto\InputPraticienDTO;
use praticien\core\dto\PraticienDTO;
use praticien\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(string $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;

    public function getPraticiens(): array;


}