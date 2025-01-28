<?php

namespace rdv\core\services\patient;

use rdv\core\dto\InputPatientDTO;
use rdv\core\dto\PatientDTO;
use rdv\core\repositoryInterfaces\PatientRepositoryInterface;
use rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use rdv\core\domain\entities\Patient\Patient;
use rdv\core\services\patient\ServicePatientInvalidDataException;

class ServicePatient implements ServicePatientInterface
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function getPatients(): array
    {
        $patientsDTO = $this->patientRepository->getPatients();
        foreach ($patientsDTO as $p){
            $patientsDTO[] = new PatientDTO($p);
        }
        return $patientsDTO;
    }

    public function getPatientById(string $id): PatientDTO
    {
        try {
            $patient = $this->patientRepository->getPatientById($id);
            return new PatientDTO($patient);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServicePatientInvalidDataException('invalid Patient ID');
        }
    }

    public function createPatient(InputPatientDTO $p): PatientDTO
    {
        return new PatientDTO($p);
    }

    /*public function getPatientByNom(string $nom): array
    {
        $patientsDTO = [];
        $patients = $this->patientRepository->getPatientByNom($nom);
        foreach ($patients as $p){
            $patientsDTO[] = new PatientDTO($p);
        }
        return $patientsDTO;
    }*/
}