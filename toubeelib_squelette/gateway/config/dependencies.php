<?php

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Gateway\Application\Actions\GatewayAccesPraticiensAction;


return[
    'toubeelib.client' => function () {
        return new Client([
            'base_uri' => 'http://api.toubeelib:80',
            'timeout' => 2.0,
        ]);
    },

    GatewayAccesPraticiensAction::class =>function (ContainerInterface $c) {
        return new GatewayAccesPraticiensAction($c->get('toubeelib.client'));
    }
];
