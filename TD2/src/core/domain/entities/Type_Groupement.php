<?php
namespace iutnc\doctrine\src\core\domain\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "type_groupement")]
class Type_Groupement{

        #[Id]
        #[Column(type: "uuid")]
        #[GeneratedValue(strategy: "UUID")]
        private string $id;

        #[Column(type: "string", length: 48)]
        private string $typeLibelle;

        #[Column(type: "string", length: 255)]
        private string $typeDescription;


}
