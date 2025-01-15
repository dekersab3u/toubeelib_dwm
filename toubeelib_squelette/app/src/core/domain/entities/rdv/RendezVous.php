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


    public function __construct(string $ID_Pa, string $ID_P, \DateTimeImmutable $d)
    {
        $this->ID_Patient = $ID_P;
        $this->ID_Praticien= $ID_Pa;
        $this->status = 'prévu';
        $this->dateRdv = $d;
        $this->specialite = ' ';
    }

    public function __toString(): string
    {
        return "Rendez-vous [Patient: $this->ID_Patient, Praticien: $this->ID_Praticien, Spécialité: $this->specialite, Date: " . $this->dateRdv->format('Y-m-d H:i') . ", Statut: $this->status]";
    }

    public function toDTO() : rdvDTO{
        return new rdvDTO($this);
    }

    public function setStatus(string $sta){
       $this->status = $sta;
    }

    public function setIDPatient(string $ID_Patient): void{
        $this->ID_Patient = $ID_Patient;
    }

    public function setSpecialite(string $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function getID_Patient(): string
    {
        return $this->ID_Patient;
    }

    public function getID_Praticien(): string
    {
        return $this->ID_Praticien;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function getDateRdv(): \DateTimeImmutable
    {
        return $this->dateRdv;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getID(): string
    {
        return $this->ID;
    }

    public function setID(string $ID): void
    {
        $this->ID = $ID;
    }






}