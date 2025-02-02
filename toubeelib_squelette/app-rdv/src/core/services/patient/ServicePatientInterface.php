<?php

namespace rdv\core\services\patient;

use rdv\core\dto\InputPatientDTO;
use rdv\core\dto\PatientDTO;
use Respect\Validation\Exceptions\NestedValidationException;
use rdv\core\domain\entities\praticien\Praticien;
use rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException;

interface ServicePatientInterface {
    public function getPatients(): array;
    public function getPatientById(string $id): PatientDTO;
    public function createPatient(InputPatientDTO $p): PatientDTO;
}