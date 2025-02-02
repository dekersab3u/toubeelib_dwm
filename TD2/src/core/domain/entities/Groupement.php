<?php
namespace iutnc\doctrine\src\core\domain\entities;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use iutnc\doctrine\src\core\domain\entities\Praticien;
use iutnc\doctrine\src\core\domain\entities\Type_Groupement;

#[Entity]
#[Table(name: "groupement")]
class Groupement
{

    #[Id]
    #[Column(type: "uuid")]
    #[GeneratedValue(strategy: "UUID")]
    private string $id;

    #[Column(type: "string", length: 50)]
    private string $nom;

    #[Column(type: "string", length: 100)]
    private string $adresse;

    #[Column(type: "string", length: 100)]
    private string $email;

    #[Column(type: "string", length: 20)]
    private string $telephone;

    #[OneToMany(mappedBy: "groupement", targetEntity: Praticien::class)]
    private Collection $praticiens;

    #[ManyToOne(targetEntity: Type_Groupement::class)]
    #[JoinColumn(name: "type__id", referencedColumnName: "id", nullable: false)]
    private Type_Groupement $type_id;



}

