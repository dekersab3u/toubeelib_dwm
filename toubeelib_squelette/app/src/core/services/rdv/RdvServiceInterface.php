<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\rdvDTO;

interface RdvServiceInterface
{
    public function consulterRDV(string $ID) : rdvDTO;

}