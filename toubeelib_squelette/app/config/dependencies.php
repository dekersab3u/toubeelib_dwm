<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use \toubeelib\core\services\rdv\RdvServiceInterface;
use \toubeelib\application\actions\AccesRdvAction;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;
use \toubeelib\application\actions\ModifRdvAction;
use \toubeelib\application\actions\AnnulerRdvAction;
use \toubeelib\application\actions\PracticienDisponibiliteAction;
use \toubeelib\core\services\praticien\ServicePraticienInterface;

return [


    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayPraticienRepository();
    },

    RdvRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayRdvRepository();
    },

    RdvServiceInterface::class => function (ContainerInterface $c)
    {
        return new \toubeelib\core\services\rdv\ServiceRDV(
            $c->get(RdvRepositoryInterface::class),
            $c->get(PraticienRepositoryInterface::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new \toubeelib\core\services\praticien\ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    AccesRdvAction::class => function(ContainerInterface $c){
        return new AccesRdvAction($c->get(RdvServiceInterface::class));
    },

    ModifRdvAction::class => function (ContainerInterface $c) {
        return new ModifRdvAction($c->get(RdvServiceInterface::class));
    },
    AnnulerRdvAction::class => function (ContainerInterface $c){
        return new AnnulerRdvAction($c->get(RdvServiceInterface::class));
    },

    PracticienDisponibiliteAction::class => function (ContainerInterface $c){
        return new PracticienDisponibiliteAction($c->get(RdvServiceInterface::class), $c->get(ServicePraticienInterface::class));
    }

];