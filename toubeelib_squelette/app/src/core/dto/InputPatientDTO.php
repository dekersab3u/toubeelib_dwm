<?php

namespace toubeelib\core\dto;

use Cassandra\Timestamp;

class InputPatientDTO extends DTO
{
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected Timestamp $dateNaiss;

    public function __construct(string $nom, string $prenom, string $email, Timestamp $dateNaiss) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->dateNaiss = $dateNaiss;
    }

}