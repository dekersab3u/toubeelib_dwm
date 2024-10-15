<?php

namespace toubeelib\infrastructure\repositories;

use toubeelib\core\domain\entities\Patient;
use toubeelib\core\repositoryInterfaces\PatientRepositoryInterface;

class ArrayPatientRepository implements PatientRepositoryInterface {

    private array $patients = [];

    public function __construct(array $patients = []) {
        $this->patients['pa1'] = new Patient('pa1', "jean", "dupont", new \DateTimeImmutable('1980-05-15'), "jdupont@hottemail.com");
        $this->patients['pa2'] = new Patient('pa2', "Marie", "Durand", new \DateTimeImmutable('1975-03-10'), "mdurand@mail.com");
        $this->patients['pa3'] = new Patient('pa3', "Luc", "Martin", new \DateTimeImmutable('1990-07-22'), "lmartin@example.com");
        $this->patients['pa4'] = new Patient('pa4', "Sophie", "Bernard", new \DateTimeImmutable('1988-11-30'), "sbernard@webmail.com");
        $this->patients['pa5'] = new Patient('pa5', "Paul", "Lefevre", new \DateTimeImmutable('2000-01-18'), "plefevre@domain.fr");
        $this->patients['pa6'] = new Patient('pa6', "Julie", "Moreau", new \DateTimeImmutable('1995-06-02'), "jmoreau@fakemail.com");

    }
}