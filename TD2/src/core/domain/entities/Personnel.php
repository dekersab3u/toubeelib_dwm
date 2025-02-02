<?php
namespace iutnc\doctrine\src\core\domain\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;


#[Entity]
#[Table(name: "Personnel")]
class Personnel{

    #[Id]
    #[Column(type: "uuid")]
    #[GeneratedValue(strategy: "UUID")]
    private string $id;


    #[Column(name:"nom", type: Types::STRING, length: 48)]
    private string $nom;

    #[Column(name:"prenom", type: Types::STRING, length: 48)]
    private string $prenom;

    #[Column(name:"mail", type: Types::STRING, length: 128)]
    private string $mail;

    #[Column(name:"telephone", type: Types::STRING, length:24)]
    private string $telephone;

    #[Column(name:"ville", type: Types::STRING, length: 48)]
    private string $ville;





}