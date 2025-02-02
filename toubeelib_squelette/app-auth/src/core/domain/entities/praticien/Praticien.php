<?php

namespace toubeelib\core\domain\entities\praticien;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\PraticienDTO;

class Praticien extends Entity
{
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected array $specialites;

    public function __construct(string $nom, string $prenom, string $adresse, string $tel)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->tel = $tel;
        $this->specialites = [];
    }


    public function addSpecialite(Specialite $specialite): void
    {
        $this->specialites[] = $specialite;
    }


    public function removeSpecialite(Specialite $specialite): void
    {
        $this->specialites = array_filter($this->specialites, function ($sp) use ($specialite) {
            return $sp->getID() !== $specialite->getID();
        });
    }


    public function toDTO(): PraticienDTO
    {
        return new PraticienDTO($this);
    }

}