<?php

namespace toubeelib\core\services\patient;

use toubeelib\core\dto\PatientDTO;
use toubeelib\core\dto\InputPatientDTO;
use Respect\Validation\Exceptions\NestedValidationException;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

interface ServicePatientInterface {
    public function getPatients(): array;
    public function getPatientById(string $id): PatientDTO;
    public function createPatient(InputPatientDTO $p): PatientDTO;
    public function getPatientByNom(string $nom): array;
    

}