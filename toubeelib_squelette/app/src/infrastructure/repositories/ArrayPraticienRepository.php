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

    const SPECIALITES = [
        'A' => [
            'ID' => 'A',
            'label' => 'Dentiste',
            'description' => 'Spécialiste des dents'
        ],
        'B' => [
            'ID' => 'B',
            'label' => 'Ophtalmologue',
            'description' => 'Spécialiste des yeux'
        ],
        'C' => [
            'ID' => 'C',
            'label' => 'Généraliste',
            'description' => 'Médecin généraliste'
        ],
        'D' => [
            'ID' => 'D',
            'label' => 'Pédiatre',
            'description' => 'Médecin pour enfants'
        ],
        'E' => [
            'ID' => 'E',
            'label' => 'Médecin du sport',
            'description' => 'Maladies et trausmatismes liés à la pratique sportive'
        ],
    ];

    private array $praticiens = [];

    /*public function __construct() {
        $this->praticiens['p1'] = new Praticien( 'Dupont', 'Jean', 'nancy', '0123456789');
        $this->praticiens['p1']->addSpecialite(new Specialite('A', 'Dentiste', 'Spécialiste des dents'));
        $this->praticiens['p1']->addSpecialite(new Specialite('D', 'Généraliste', 'Médecin généraliste'));
        $this->praticiens['p1']->setID('p1');

        $this->praticiens['p2'] = new Praticien( 'Durand', 'Pierre', 'vandeuve', '0123456789');
        $this->praticiens['p2']->addSpecialite(new Specialite('B', 'Ophtalmologue', 'Spécialiste des yeux'));
        $this->praticiens['p2']->setID('p2');

        $this->praticiens['p3'] = new Praticien( 'Martin', 'Marie', '3lassou', '0123456789');
        $this->praticiens['p3']->addSpecialite(new Specialite('C', 'Généraliste', 'Médecin généraliste'));
        $this->praticiens['p3']->setID('p3');

    }*/

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