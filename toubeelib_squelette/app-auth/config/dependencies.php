<?php

use Psr\Container\ContainerInterface;
use toubeelib\application\actions\RegisterAction;
use toubeelib\application\middlewares\AuthnMiddleware;
use toubeelib\application\providers\AuthnProviderInterface;
use toubeelib\application\providers\JWTAuthnProvider;
use toubeelib\application\providers\JWTManager;
use toubeelib\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\core\services\auth\AuthnService;
use toubeelib\core\services\auth\AuthnServiceInterface;
use toubeelib\core\services\auth\AuthzService;
use toubeelib\core\services\auth\AuthzServiceInterface;
use toubeelib\application\actions\SignInAction;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\core\services\auth\AuthService;
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

    SignInAction::class => function (ContainerInterface $c){
        return new SignInAction($c->get(AuthnProviderInterface::class));
    },

    RegisterAction::class => function (ContainerInterface $c){
        return new RegisterAction($c->get(AuthnProviderInterface::class));
    },

    \toubeelib\application\actions\ValiderTokenAction::class => function(Container $c){
        return new \toubeelib\application\actions\ValiderTokenAction($c->get(AuthnProviderInterface::class));
    }

];