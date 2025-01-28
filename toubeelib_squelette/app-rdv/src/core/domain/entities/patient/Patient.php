<?php

namespace rdv\core\domain\entities\patient;

use Cassandra\Timestamp;
use Respect\Validation\Rules\Date;
use rdv\core\domain\entities\Entity;

class Patient extends Entity {


    protected string $email;
    protected int $role;
    protected string $nom;
    protected string $prenom;
    //protected timestamp $dateNais;



    public function __construct(string $email, int $role, string $nom, string $prenom/*,timestamp $dateNais*/)
    {
        $this->email = $email;
        $this->role = $role;
        $this->nom = $nom;
        $this->prenom = $prenom;
       // $this->dateNais = $dateNais;
    }

    public function getID(): string
    {
        return $this->ID;
    }


}