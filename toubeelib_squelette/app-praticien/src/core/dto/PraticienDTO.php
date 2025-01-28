<?php

namespace praticien\core\dto;

use praticien\core\domain\entities\praticien\Praticien;
use praticien\core\dto\DTO;

class PraticienDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected array $specialites_labels;

    public function __construct(Praticien $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->specialites_labels = array_map(function($sp){
            return $sp->label;
        }, $p->specialites);
    }


}