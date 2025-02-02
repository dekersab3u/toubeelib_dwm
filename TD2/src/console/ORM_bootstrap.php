<?php


require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;


$entity_path = [__DIR__ . '/../core/domain/entities/'];
$isDevMode = true;


$dbParams = parse_ini_file(__DIR__ . '/../conf_td2/db.conf.ini');


$config = ORMSetup::createAttributeMetadataConfiguration($entity_path, $isDevMode);


$connection = DriverManager::getConnection($dbParams, $config);


$connection = DriverManager::getConnection($dbParams, $config);
try {
    $entityManager = new EntityManager($connection, $config);
} catch (\Doctrine\ORM\Exception\MissingMappingDriverImplementation $e) {
    echo "Erreur de configuration Doctrine : " . $e->getMessage();
    exit;
}

return $entityManager;
