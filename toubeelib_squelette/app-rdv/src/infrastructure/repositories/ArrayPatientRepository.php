<?php

namespace rdv\infrastructure\repositories;

use PDO;
use Ramsey\Uuid\Uuid;
use rdv\core\domain\entities\Patient\Patient;
use rdv\core\repositoryInterfaces\PatientRepositoryInterface;
use rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayPatientRepository implements PatientRepositoryInterface {

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPatientById(string $id): Patient
    {
        if (!Uuid::isValid($id)) {
            throw new RepositoryEntityNotFoundException("id patient non valide");
        }
        $query = "SELECT id,email, role, nom, prenom, dateNais FROM patient WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new RepositoryEntityNotFoundException("Aucun patient trouvé avec l'ID $id.");
        }
        $patient = new Patient(
            $row['email'],
            $row['role'],
            $row['nom'],
            $row['prenom'],
            $row['dateNais'],
        );

        return $patient;
    }
}


