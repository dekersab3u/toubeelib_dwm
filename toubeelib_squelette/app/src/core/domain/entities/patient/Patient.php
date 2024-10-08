<?php

namespace toubeelib\core\domain\entities\Patient;

use Respect\Validation\Rules\Date;
use toubeelib\core\domain\entities\Entity;

class Patient extends Entity {

    protected ?string $ID;
    protected string $firstName;
    protected string $lastName;
    protected Date $birthDate;
    protected string $email;

    //protected Dossier $dossier;

    public function __construct(string $id, string $firstName, string $lastName, Date $birthDate, string $email) {
        $this->ID = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->email = $email;

    }

    public function getID(): string {
        return $this->ID;
    }

}