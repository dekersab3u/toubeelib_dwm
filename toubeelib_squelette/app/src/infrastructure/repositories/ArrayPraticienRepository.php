<?php

namespace toubeelib\infrastructure\repositories;

use PDO;
use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayPraticienRepository implements PraticienRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSpecialitesByPraticienId(string $id): array
    {
        error_log("Looking for specialites of praticien with ID: " . $id);
        $query = "SELECT id_spe FROM PraticienToSpecialite WHERE id_prat = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            throw new RepositoryEntityNotFoundException("Praticien avec l'ID $id non trouvé.");
        }

        $specialites = $rows;

        if (empty($specialites)) {
            throw new RepositoryEntityNotFoundException("Aucune spécialité trouvée pour le praticien avec l'ID $id.");
        }

        /*$specialitesDTO = [];
        foreach ($praticien->specialites as $specialite) {
            $specialitesDTO[] = new Specialite($specialite->getID(), $specialite->label, $specialite->description);
        }*/

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
        //verifier que l'id est bien un uuid
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