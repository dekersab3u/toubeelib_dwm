<?php
namespace iutnc\doctrine\src\core\domain\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "specialite")]
class Specialite{

    #[ID]
    #[Column(type: TYPES::INTEGER)]
    #[GeneratedValue(strategy: 'AUTO')]
    private string $id;

    #[Column(type: "string", length: 50)]
    private string $libelle;

    #[Column(type: "string", length: 255)]
    private string $description;


}