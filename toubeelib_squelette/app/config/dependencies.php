<?php

use Psr\Container\ContainerInterface;
use toubeelib\application\actions\AccesRdvsAction;
use toubeelib\application\actions\AccesRdvsByPraticienIdAction;
use toubeelib\application\actions\PriseRdvAction;
use toubeelib\application\actions\RegisterAction;
use toubeelib\application\middlewares\AuthnMiddleware;
use toubeelib\application\providers\AuthnProviderInterface;
use toubeelib\application\providers\JWTAuthnProvider;
use toubeelib\application\providers\JWTManager;
use toubeelib\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\core\services\auth\AuthnService;
use toubeelib\core\services\auth\AuthnServiceInterface;
use toubeelib\core\services\auth\AuthzService;
use toubeelib\core\services\auth\AuthzServiceInterface;
use \toubeelib\core\services\rdv\RdvServiceInterface;
use \toubeelib\application\actions\AccesRdvByIdAction;
use toubeelib\infrastructure\repositories\ArrayPatientRepository;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;
use \toubeelib\application\actions\ModifRdvAction;
use \toubeelib\application\actions\AnnulerRdvAction;
use \toubeelib\application\actions\PracticienDisponibiliteAction;
use \toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\application\actions\SignInAction;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\core\services\auth\AuthService;
use toubeelib\application\actions\GetPraticienByID;
use toubeelib\application\actions\GetPraticiens;
use toubeelib\infrastructure\repositories\UserRepository;

return [

    PDO::class => function (ContainerInterface $c) {
        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $_ENV['DB_HOST'], $_ENV['DB_PORT'],$_ENV['DB_NAME']);
        return new PDO($dsn, $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    },

    JWTManager::class => function () {
        return new JWTManager();
    },

    AuthnMiddleware::class =>function (ContainerInterface $c){
        return new AuthnMiddleware($c->get(AuthnProviderInterface::class));
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

    UserRepositoryInterface::class => function(ContainerInterface $c){
        return new UserRepository($c->get(PDO::class));
    },


    AuthnServiceInterface::class => function (ContainerInterface $c){
        return new AuthnService($c->get(UserRepositoryInterface::class));
    },

    AuthnProviderInterface::class =>function (ContainerInterface $c){
        return new JWTAuthnProvider($c->get(JWTManager::class), $c->get(AuthnServiceInterface::class));
    },

    AuthzServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzService($c->get(UserRepositoryInterface::class));
    },

    RdvServiceInterface::class => function (ContainerInterface $c) {
        return new \toubeelib\core\services\rdv\ServiceRDV($c->get(RdvRepositoryInterface::class), $c->get(PraticienRepositoryInterface::class), $c->get(PatientRepositoryInterface::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new \toubeelib\core\services\praticien\ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get(AuthnProviderInterface::class));
    },

    RegisterAction::class => function (ContainerInterface $c){
        return new RegisterAction($c->get(AuthnProviderInterface::class));
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

    GetPraticienByID::class => function (ContainerInterface $c){
        return new GetPraticienByID($c->get(ServicePraticienInterface::class));
    },

    GetPraticiens::class => function (ContainerInterface $c) {
        return new GetPraticiens($c->get(ServicePraticienInterface::class));
    }

];