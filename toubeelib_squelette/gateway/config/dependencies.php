<?php

use gateway\application\actions\GatewayGetRdvByPraticienIdAction;
use gateway\application\middleware\CorsMiddleware;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use gateway\application\actions\GatewayRegisterAction;
use gateway\application\actions\GatewaySignInAction;


return[
    'toubeelib.client' => function (ContainerInterface $c) {
        return new Client([
            'base_uri' => $c->get('api.toubeelib'),
            'timeout' => 10.0,
        ]);
    },

    'toubeelib.praticien' => function (ContainerInterface $c){
        return new Client([
            'base_uri' => $c->get('api.praticien'),
            'timeout' => 10.0,
        ]);
    },

    'toubeelib.auth' => function(ContainerInterface $c){
        return new Client([
            'base_uri' => $c->get('api.auth'),
            'timeout' => 10.0,
        ]);
    },

    'toubeelib.rdv' => function (ContainerInterface $c){
        return new Client([
            'base_uri' => $c->get('api.rdv'),
            'timeout => 10.0,'
        ]);
    },

    CorsMiddleware::class => function (){
        return new CorsMiddleware();
    },

    \gateway\application\actions\HomeAction::class =>function(ContainerInterface $c){
        return new \gateway\application\actions\HomeAction($c->get('toubeelib.client'));
    },

    \gateway\application\actions\GatewayGetPraticiensAction::class => function(ContainerInterface $c){
        return new \gateway\application\actions\GatewayGetPraticiensAction($c->get('toubeelib.praticien'));
    },
    GatewayGetRdvByPraticienIdAction::class => function(ContainerInterface $c){
        return new GatewayGetRdvByPraticienIdAction($c->get('toubeelib.client'));
    },

    GatewaySignInAction::class => function(ContainerInterface $c){
        return new GatewaySignInAction($c->get('toubeelib.auth'));
    },

    GatewayRegisterAction::class => function(ContainerInterface $c){
        return new GatewayRegisterAction($c->get('toubeelib.auth'));
    }
];
