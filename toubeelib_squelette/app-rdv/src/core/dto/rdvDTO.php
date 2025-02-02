<?php

namespace rdv\core\dto;

use rdv\core\domain\entities\praticien\Praticien;
use rdv\core\dto\DTO;

namespace rdv\core\dto;
use rdv\core\domain\entities\rdv\RendezVous;

class rdvDTO extends DTO
{
    protected string $ID;
    protected string $ID_Patient;

    protected string $ID_Praticien;

    protected string $status;

    protected string $specialite;

    protected \DateTimeImmutable $dateRdv;

    public function __construct(RendezVous $r)
    {
        $this->ID = $r->getID();
        $this->ID_Patient = $r->ID_Patient;
        $this->ID_Praticien = $r->ID_Praticien;
        $this->status = $r->status;
        $this->dateRdv = $r->dateRdv;
        $this->specialite = $r->specialite;

    }



}