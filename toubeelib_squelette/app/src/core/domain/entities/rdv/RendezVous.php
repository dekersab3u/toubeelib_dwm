<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\rdvDTO;

class RendezVous extends Entity
{

    protected string $ID_Praticien;
    protected string $ID_Patient;

    public string $status;

    protected string $specialite;

    protected \DateTimeImmutable $dateRdv;

    public function __construct(string $ID_Pa, string $ID_P, string $s, \DateTimeImmutable $d)
    {
        $this->ID_Patient = $ID_P;
        $this->ID_Praticien= $ID_Pa;
        $this->status = $s;
        $this->dateRdv = $d;
        $this->specialite = ' ';
    }

    public function toDTO() : rdvDTO{
        return new rdvDTO($this);
    }

    public function setStatus(string $sta){
       $this->status = $sta;
    }

}