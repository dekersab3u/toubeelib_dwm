<?php

namespace rdv\core\dto;

class InputPatientDTO extends DTO
{
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected \DateTimeImmutable $dateNaissance;

    public function __construct(string $nom, string $prenom, string $adresse, string $tel, string $dateNaissance, string $sexe, string $profession, string $situationFamiliale, string $nbEnfants, string $antecedents, string $allergies, string $medicaments, string $dateCreation, string $dateModification) {

    }

}