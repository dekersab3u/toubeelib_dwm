<?php

namespace rdv\infrastructure\repositories;

use PDO;
use Ramsey\Uuid\Uuid;
use rdv\core\domain\entities\praticien\Praticien;
use rdv\core\domain\entities\rdv\RendezVous;
use rdv\core\repositoryInterfaces\RdvRepositoryInterface;
use rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayRdvRepository implements RdvRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRdvs() : array{
        $query = "SELECT id, id_patient, id_praticien, id_specialite, status, date_rdv FROM rdvs";
        $stmt = $this->pdo->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($row) {
            $rdv = new RendezVous(
                $row['id_patient'],
                $row['id_praticien'],
                new \DateTimeImmutable($row['date_rdv'])
            );
            $rdv->setID($row['id']);
            $rdv->setStatus($row['status']);
            $rdv->setSpecialite($row['id_specialite']);
            return $rdv;
        }, $rows);
    }

    public function getRdvById(string $id): RendezVous
    {
        error_log("Looking for RDV with ID: " . $id);
        $query = "SELECT id, id_patient, id_praticien, id_specialite, status, date_rdv FROM rdvs WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Query executed. Result: " . json_encode($row));

        if (!$row) {
            throw new RepositoryEntityNotFoundException("Rendez-vous $id not found");
        }

        $rdv = new RendezVous(
            $row['id_praticien'],
            $row['id_patient'],
            new \DateTimeImmutable($row['date_rdv'])
        );
        $rdv->setID($row['id']);
        $rdv->setStatus($row['status']);

        return $rdv;
    }



    public function getPraticienById(string $id): Praticien
    {
        $query = "SELECT id, email, nom, prenom, tel FROM praticien WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new RepositoryEntityNotFoundException("Praticien $id not found");
        }

        $praticien = new Praticien(
            $row['nom'],
            $row['prenom'],
            $row['adresse'],
            $row['tel'],
        );

        return $praticien;
    }

    public function getRdvsByPraticienId(string $id): array
    {
        $query = "SELECT id, id_patient, id_praticien, id_specialite, status, date_rdv FROM rdvs WHERE id_praticien = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $rdvs = [];
        foreach ($rows as $row) {
            $rdv = new RendezVous(
                $row['id_praticien'],
                $row['id_patient'],
                new \DateTimeImmutable($row['date_rdv'])
            );
            $rdv->setID($row['id']);
            $rdv->setStatus($row['status']);
            $rdvs[] = $rdv;
        }

        return $rdvs;
    }

    public function save(RendezVous $rdv): void
    {
        $query = "INSERT INTO rdvs (id, id_patient, id_praticien, id_specialite, date_rdv, status) 
              VALUES (:id, :id_patient, :id_praticien, :id_specialite, :date_rdv, :status)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'id' => $rdv->getID(),
            'id_patient' => $rdv->getID_Patient(),
            'id_praticien' => $rdv->getID_Praticien(),
            'id_specialite' => $rdv->getSpecialite(),
            'date_rdv' => $rdv->getDateRdv()->format('Y-m-d H:i:s'),
            'status' => $rdv->getStatus(),
        ]);
    }

}
