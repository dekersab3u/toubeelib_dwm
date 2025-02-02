<?php
namespace iutnc\doctrine\src\core\domain\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "praticien")]
class Praticien
{
    #[ID]
    #[Column(type: "uuid")]
    #[GeneratedValue(strategy: "UUID")]
    private string $id;

    #[Column(type: "string", length: 50)]
    private string $nom;

    #[Column(type: "string", length: 50)]
    private string $prenom;

    #[Column(type: "string", length: 100, unique: true)]
    private string $email;

    #[Column(type: "string", length: 20)]
    private string $telephone;

    #[Column(type: "string", length: 50)]
    private string $ville;

    #[ManyToOne(targetEntity: Specialite::class)]
    #[JoinColumn(name: "specialite_id", referencedColumnName: "id", nullable: false)]
    private Specialite $specialite;

    #[ManyToOne(targetEntity: Groupement::class,) ]
    #[JoinColumn(name: "groupement_id", referencedColumnName: "id", nullable: true)]
    private ?Groupement $groupement = null;

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function setGroupement(Groupement $groupement): void
    {
        $this->groupement = $groupement;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }


}