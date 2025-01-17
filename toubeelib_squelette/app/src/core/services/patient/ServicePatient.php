<?php

namespace toubeelib\core\services\patient;

use toubeelib\core\dto\InputPatientDTO;
use toubeelib\core\dto\PatientDTO;

class ServicePatient implements ServicePatientInterface
{

    public function getPatients(): array
    {
        // TODO: Implement getPatients() method.
    }

    public function getPatientById(string $id): PatientDTO
    {
        // TODO: Implement getPatientById() method.
    }

    public function createPatient(InputPatientDTO $p): PatientDTO
    {
        return new PatientDTO($p);
    }

    public function getPatientByNom(string $nom): array
    {
        // TODO: Implement getPatientByNom() method.
    }
}