<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\rdvDTO;

class RendezVous extends Entity
{

    protected string $ID_Patient;

    protected string $ID_Praticien;

    protected string $status;

    protected string $specialite;

    protected \DateTime $dateRdv;

    public function __construct(string $ID, string $ID_P, string $ID_Pa, string $s, \DateTime $d)
    {
        $this->ID = $ID;
        $this->ID_Patient = $ID_P;
        $this->ID_Praticien= $ID_Pa;
        $this->status = $s;
        $this->dateRdv = $d;
    }

    public function toDTO() : rdvDTO{
        return new rdvDTO($this);
    }

}