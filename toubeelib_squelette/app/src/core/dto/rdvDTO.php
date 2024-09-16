<?php

namespace toubeelib\core\dto;

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\dto\DTO;

namespace toubeelib\core\dto;
use toubeelib\core\domain\entities\rdv\RendezVous;

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
        $this->specialite = $r ->specialite;

    }

    public function __get($nomPropriete): mixed
    {
        // Vérifie si la propriété demandée existe dans la classe
        if (property_exists($this, $nomPropriete)) {
            return $this->$nomPropriete;
        }
        // Gestion du cas où la propriété n'existe pas
        trigger_error("Propriété '$nomPropriete' introuvable", E_USER_NOTICE);
        return null;
    }


}