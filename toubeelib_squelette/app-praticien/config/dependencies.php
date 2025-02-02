<?php

use Psr\Container\ContainerInterface;
use praticien\core\repositoryInterfaces\PraticienRepositoryInterface;
use praticien\infrastructure\repositories\ArrayPraticienRepository;
use praticien\core\services\praticien\ServicePraticienInterface;
use praticien\application\actions\GetPraticienByID;
use praticien\application\actions\GetPraticiens;

return [

    PDO::class => function (ContainerInterface $c) {
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_PORT'],$_ENV['DB_NAME']);
        return new PDO($dsn, $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    },

    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayPraticienRepository($c->get(PDO::class));

    },


    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new \praticien\core\services\praticien\ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },


    PracticienDisponibiliteAction::class => function (ContainerInterface $c){
        return new PracticienDisponibiliteAction($c->get(RdvServiceInterface::class), $c->get(ServicePraticienInterface::class));
    },

    GetPraticienByID::class => function (ContainerInterface $c){
        return new GetPraticienByID($c->get(ServicePraticienInterface::class));
    },

    GetPraticiens::class => function (ContainerInterface $c) {
        return new GetPraticiens($c->get(ServicePraticienInterface::class));
    }

];