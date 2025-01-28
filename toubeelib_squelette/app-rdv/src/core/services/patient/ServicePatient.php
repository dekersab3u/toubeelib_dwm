<?php

namespace rdv\core\services\patient;

use rdv\core\dto\InputPatientDTO;
use rdv\core\dto\PatientDTO;

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