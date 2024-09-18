<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use \toubeelib\core\services\rdv\RdvServiceInterface;
use \toubeelib\application\actions\AccesRdvAction;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;

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

    AccesRdvAction::class => function(ContainerInterface $c){
        return new AccesRdvAction($c->get(RdvServiceInterface::class));
    },

];