<?php

use gateway\application\actions\GatewayAccesPraticiensAction;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;


return[
    'toubeelib.client' => function (ContainerInterface $c) {
        return new Client([
            'base_uri' => $c->get('api.toubeelib'),
            'timeout' => 10.0,
        ]);
    },

    GatewayAccesPraticiensAction::class =>function (ContainerInterface $c) {
        return new GatewayAccesPraticiensAction($c->get('toubeelib.client'));
    },

    \gateway\application\actions\HomeAction::class =>function(ContainerInterface $c){
        return new \gateway\application\actions\HomeAction($c->get('toubeelib.client'));
    }
];
