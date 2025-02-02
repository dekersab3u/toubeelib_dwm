<?php

namespace rdv\core\services\praticien;

use rdv\core\dto\InputPraticienDTO;
use rdv\core\dto\PraticienDTO;
use rdv\core\dto\SpecialiteDTO;

interface ServicePraticienInterface
{

    public function createPraticien(InputPraticienDTO $p): PraticienDTO;
    public function getPraticienById(string $id): PraticienDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;

    public function getPraticiens(): array;


}