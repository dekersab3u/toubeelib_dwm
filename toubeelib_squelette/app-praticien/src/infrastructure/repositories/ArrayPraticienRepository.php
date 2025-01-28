<?php

namespace praticien\infrastructure\repositories;

use PDO;
use Ramsey\Uuid\Uuid;
use praticien\core\domain\entities\praticien\Praticien;
use praticien\core\domain\entities\praticien\Specialite;
use praticien\core\repositoryInterfaces\PraticienRepositoryInterface;
use praticien\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayPraticienRepository implements PraticienRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSpecialitesByPraticienId(string $id): array
    {
        if (!Uuid::isValid($id)) {
            throw new RepositoryEntityNotFoundException("id praticien non valide");
        }
        $query = "
        SELECT s.id AS id_spe, s.label, s.description
        FROM PraticienToSpecialite pts
        JOIN Specialite s ON pts.id_spe = s.id
        WHERE pts.id_prat = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            throw new RepositoryEntityNotFoundException("Aucune spécialité trouvée pour le praticien avec l'ID $id.");
        }


        $specialites = [];
        foreach ($rows as $row) {
            $specialites[] = new Specialite(
                $row['id_spe'],
                $row['label'],
                $row['description']
            );
        }

        return $specialites;
    }


    public function save(Praticien $praticien): string
    {
        // TODO : prévoir le cas d'une mise à jour - le praticien possède déjà un ID
		$ID = Uuid::uuid4()->toString();
        $praticien->setID($ID);
        $stmt = $this->pdo->prepare("INSERT INTO praticien (id, email, nom, prenom, adresse, tel) VALUES (:id, :email, :nom, :prenom, :adresse, :tel)");
        return $ID;
    }

    public function getPraticienById(string $id): Praticien
    {

        if (!Uuid::isValid($id)) {
            throw new RepositoryEntityNotFoundException("id praticien non valide");
        }
        $query = "SELECT id,email, nom, prenom, tel FROM praticien WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $praticien = new Praticien(
            $row['nom'],
            $row['prenom'],
            $row['email'],
            $row['tel'],
        );
        $praticien->setID($row['id']);
        return $praticien;
    }

    public function getPraticiens(): array
    {
        $query = "SELECT id,email, nom, prenom, tel FROM praticien";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $praticiens = [];
        foreach ($rows as $row) {
            $praticien = new Praticien(
                $row['email'],
                $row['nom'],
                $row['prenom'],
                $row['tel'],
            );
            $praticien->setID($row['id']);
            $praticiens[] = $praticien;
        }
        return $praticiens;
    }
}