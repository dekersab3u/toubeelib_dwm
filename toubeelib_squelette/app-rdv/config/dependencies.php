<?php

use Psr\Container\ContainerInterface;
use rdv\application\actions\AccesRdvsAction;
use rdv\application\actions\AccesRdvsByPraticienIdAction;
use rdv\application\actions\GetPatientsAction;
use rdv\application\actions\PriseRdvAction;
use rdv\core\repositoryInterfaces\PatientRepositoryInterface;
use rdv\core\repositoryInterfaces\PraticienRepositoryInterface;
use rdv\core\repositoryInterfaces\RdvRepositoryInterface;
use rdv\core\services\patient\ServicePatientInterface;
use rdv\core\services\rdv\RdvServiceInterface;
use rdv\application\actions\AccesRdvByIdAction;
use rdv\infrastructure\repositories\ArrayPatientRepository;
use rdv\infrastructure\repositories\ArrayPraticienRepository;
use rdv\infrastructure\repositories\ArrayRdvRepository;
use rdv\application\actions\ModifRdvAction;
use rdv\application\actions\AnnulerRdvAction;
use rdv\application\actions\PracticienDisponibiliteAction;
use rdv\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\core\services\auth\AuthService;


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

    PatientRepositoryInterface::class => function(ContainerInterface $c){
        return new ArrayPatientRepository($c->get(PDO::class));
    },

    RdvRepositoryInterface::class => function (ContainerInterface $c) {
        return new ArrayRdvRepository($c->get(PDO::class));
    },


    RdvServiceInterface::class => function (ContainerInterface $c) {
        return new \rdv\core\services\rdv\ServiceRDV($c->get(RdvRepositoryInterface::class), $c->get(PraticienRepositoryInterface::class), $c->get(PatientRepositoryInterface::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new \rdv\core\services\praticien\ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    AuthService::class => function (ContainerInterface $c) {
      return new AuthService($c->get(PDO::class));
    },

    AuthProvider::class => function (ContainerInterface $c){
        return new AuthProvider($c->get(AuthService::class));
    },

    AccesRdvByIdAction::class => function(ContainerInterface $c){
        return new AccesRdvByIdAction($c->get(RdvServiceInterface::class));
    },

    ModifRdvAction::class => function (ContainerInterface $c) {
        return new ModifRdvAction($c->get(RdvServiceInterface::class));
    },
    AnnulerRdvAction::class => function (ContainerInterface $c){
        return new AnnulerRdvAction($c->get(RdvServiceInterface::class));
    },

    PracticienDisponibiliteAction::class => function (ContainerInterface $c){
        return new PracticienDisponibiliteAction($c->get(RdvServiceInterface::class), $c->get(ServicePraticienInterface::class));
    },


    PriseRdvAction::class => function (ContainerInterface $c){
        return new PriseRdvAction($c->get(RdvServiceInterface::class));
    },

    AccesRdvsAction::class => function (ContainerInterface $c){
        return new AccesRdvsAction($c->get(RdvServiceInterface::class));
    },

    AccesRdvsByPraticienIdAction::class => function(ContainerInterface $c){
        return new AccesRdvsByPraticienIdAction($c->get(RdvServiceInterface::class));
    },

    GetPatientsAction::class => function (ContainerInterface $c) {
        return new GetPatientsAction($c->get(ServicePatientInterface::class));
    }

];