<?php


namespace rdv\core\dto;

use Cassandra\Timestamp;
use rdv\core\domain\entities\patient\Patient;
use rdv\core\domain\entities\praticien\Praticien;
use rdv\core\dto\DTO;


class PatientDTO extends DTO
{
    protected string $ID;
    protected string $email;
    protected int $role;
    protected string $nom;
    protected string $prenom;

    //protected timestamp $dateNais;

    public function __construct(Patient $p)
    {
        $this->ID = $p->getID();
        $this->email = $p->email;
        $this->role = $p->role;
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        //$this->dateNais = $p->dateNais;
    }



}
